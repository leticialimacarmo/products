$(window).on("load", async function () {
  const sales = new Sales();
  await sales.init();
});

class Sales {
  constructor() {
    this.itemCount = 0;
  }

  async init() {
    await this.populateSelect();
    this.formatValues();
    this.registerSales();
    this.setupUpdateModal();
    this.addParcelamento();
    this.sendDataToAPI();
    $(".select2").select2();
    $("#vendedor").val("");
    $("#cliente").val("");
    $("#produto").val("");
    $("#quantidade").val("");
    $("#valorUnitario").val("");
    $("#subtotal").val("");
  }

  formatValues() {
    $("#quantidade, #valorUnitario").on("input", function () {
      const quantidade =
        parseFloat($("#quantidade").val().replace(/\D/g, "")) || 0;
      const valorUnitario =
        parseFloat(
          $("#valorUnitario")
            .val()
            .replace(/[^\d,]/g, "")
            .replace(",", ".")
        ) || 0;
      const subtotal = quantidade * valorUnitario;

      const formattedSubtotal = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(subtotal);

      $("#subtotal").val(formattedSubtotal);
    });

    $("#valorUnitario").on("input", function () {
      let value = $(this).val().replace(/[^\d]/g, "");
      value = (parseFloat(value) / 100).toFixed(2);
      let formatted = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(value);
      $(this).val(formatted);
    });

    $("#subtotal").on("input", function () {
      let value = $(this).val().replace(/[^\d]/g, "");
      value = (parseFloat(value) / 100).toFixed(2);
      let formatted = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(value);
      $(this).val(formatted);
    });
  }

  async populateSelect() {
    const apiUrl = "./class/getOptions.php";

    try {
      const response = await fetch(apiUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!response.ok) {
        throw new Error("Erro ao buscar dados");
      }

      const data = await response.json();

      data.data.forEach((item) => {
        const option = `<option value="${item.nomeFantasia} - ${item.razaoSocial}">${item.nomeFantasia} - ${item.razaoSocial}</option>`;
        $("#cliente").append(option);
      });

      const res = await fetch(`./class/getProduct.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!res.ok) {
        throw new Error("Erro ao buscar dados");
      }

      const dados = await res.json();

      dados.data.forEach((item) => {
        const op = `<option value="${item.codigo} - ${item.descricao}">${item.codigo} - ${item.descricao}</option>`;
        $("#produto").append(op);
        $("#produto_update").append(op);
      });
    } catch (error) {
      console.error("Erro ao buscar dados:", error);
    }
  }

  validateField(fieldName) {
    const form = $("#formCadastro")[0];
    if (!form) return false;

    const input = $(form).find(`[name="${fieldName}"]`);
    const inputValue = input.val().trim();
    const errorMessage = `${fieldName} é obrigatório`;

    if (!inputValue) {
      if (!input.next(".invalid-feedback").length) {
        const errorDiv = $("<div>")
          .addClass("invalid-feedback")
          .text(errorMessage);
        input.after(errorDiv);
      }
      input.addClass("is-invalid");
      return false;
    } else {
      input.removeClass("is-invalid");
      input.next(".invalid-feedback").remove();
      return true;
    }
  }

  validateFieldUpdate(fieldName) {
    const form = $("#formAtualizacao")[0];
    if (!form) return false;

    const input = $(form).find(`[name="${fieldName}"]`);
    const inputValue = input.val().trim();
    const errorMessage = `${fieldName} é obrigatório`;

    if (!inputValue) {
      if (!input.next(".invalid-feedback").length) {
        const errorDiv = $("<div>")
          .addClass("invalid-feedback")
          .text(errorMessage);
        input.after(errorDiv);
      }
      input.addClass("is-invalid");
      return false;
    } else {
      input.removeClass("is-invalid");
      input.next(".invalid-feedback").remove();
      return true;
    }
  }

  registerSales() {
    const self = this;

    $(document).on("click", "#addItem", async function (e) {
      e.preventDefault();

      const fieldsToValidate = [
        "produto",
        "quantidade",
        "valorUnitario",
        "subtotal",
      ];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateField(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const produto = $("#produto option:selected").text();
        const quantidade = $("#quantidade").val();
        const valorUnitario = $("#valorUnitario").val();
        const subtotal = $("#subtotal").val();
        const cliente = $("#cliente").val() ?? "";
        const vendedor = $("#vendedor").val() ?? "";

        self.itemCount++;

        const newRow = `
                <tr data-id="${self.itemCount}">
                    <td>${self.itemCount}</td>
                    <td>${produto}</td>
                    <td>${cliente}</td>
                    <td>${vendedor}</td>
                    <td>${quantidade}</td>
                    <td>${valorUnitario}</td>
                    <td>${subtotal}</td>
                    <td>   
                        <button type="button" class="btn btn-warning btn-sm update-btn" data-id="${self.itemCount}" data-toggle="modal" data-target="#updateModal">
                            <i class="bi bi-pencil-square"></i> 
                        </button>
                    </td>
                </tr>
            `;
        $("#itens tbody").append(newRow);

        self.recalculateTotal();

        $("#produto").val("");
        $("#quantidade").val("");
        $("#valorUnitario").val("");
        $("#subtotal").val("");

        $("#subtotal").trigger("input");
      } else {
        console.log("Falha na validação");
      }
    });
  }

  recalculateTotal() {
    let totalItens = 0;

    $("#itens tbody tr").each(function () {
      const subtotalStr = $(this).find("td:nth-child(7)").text();
      const subtotal = parseFloat(
        subtotalStr.replace("R$", "").replace(".", "").replace(",", ".").trim()
      );

      totalItens += subtotal;
    });

    const formattedTotal = new Intl.NumberFormat("pt-BR", {
      style: "currency",
      currency: "BRL",
    }).format(totalItens);

    $("#valor_parcela").val(formattedTotal);
  }

  setupUpdateModal() {
    const self = this;

    $(document).on("click", ".update-btn", function (e) {
      e.preventDefault();

      const rowId = $(this).data("id");
      $("#updateModal").data("product-id", rowId);

      const row = $(this).closest("tr");
      const produto = row.find("td:nth-child(2)").text();
      const cliente = row.find("td:nth-child(3)").text();
      const vendedor = row.find("td:nth-child(4)").text();
      const quantidade = row.find("td:nth-child(5)").text();
      const valorUnitario = row.find("td:nth-child(6)").text();
      const subtotal = row.find("td:nth-child(7)").text();

      $("#produto_update").val(produto);
      $("#cliente_update").val(cliente);
      $("#vendedor_update").val(vendedor);
      $("#quantidade_update").val(quantidade);
      $("#valor_update").val(valorUnitario);
      $("#subtotal_update").val(subtotal);

      $("#updateModal").modal("show");
    });

    $(document).on("click", "#update", async function (e) {
      e.preventDefault();

      const fieldsToValidate = [
        "produto_update",
        "quantidade_update",
        "valor_update",
        "subtotal_update",
      ];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateFieldUpdate(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const produto = $("#produto_update").val();
        const cliente = $("#cliente_update").val();
        const vendedor = $("#vendedor_update").val();
        const quantidade = $("#quantidade_update").val();
        const valorUnitario = $("#valor_update").val();
        const subtotal = $("#subtotal_update").val();

        const rowId = $("#updateModal").data("product-id");
        const row = $(`#itens tbody tr[data-id="${rowId}"]`);

        row.find("td:nth-child(2)").text(produto);
        row.find("td:nth-child(3)").text(cliente);
        row.find("td:nth-child(4)").text(vendedor);
        row.find("td:nth-child(5)").text(quantidade);
        row.find("td:nth-child(6)").text(valorUnitario);
        row.find("td:nth-child(7)").text(subtotal);

        self.recalculateTotal();

        $("#produto_update").val("");
        $("#cliente_update").val("");
        $("#vendedor_update").val("");
        $("#quantidade_update").val("");
        $("#valor_update").val("");
        $("#subtotal_update").val("");

        $("#fecha").click();
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Preencha todos os campos obrigatórios antes de prosseguir.",
        });
      }
    });
  }

  addParcelamento() {
    const self = this;

    $(document).on("click", "#addParcela", function (e) {
      e.preventDefault();

      if (
        $("#nParcela").val() == "" ||
        $("#data_vencimento").val() == "" ||
        $("#valor_parcela").val() == ""
      ) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Preencha todos os campos obrigatórios antes de prosseguir.",
        });
        return;
      }

      const nParcelas = parseInt($("#nParcela").val());
      const dataVencimento = $("#data_vencimento").val();
      const subtotalStr = $("#valor_parcela").val();
      const subtotal = parseFloat(
        subtotalStr.replace(/[^\d,]/g, "").replace(",", ".")
      );

      $("#pagamento tbody").empty();

      const valorParcela = (subtotal / nParcelas).toFixed(2);

      const formattedValorParcela = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(valorParcela);

      for (let i = 0; i < nParcelas; i++) {
        const dataVencimentoParcela = new Date(dataVencimento);
        dataVencimentoParcela.setMonth(dataVencimentoParcela.getMonth() + i);

        const formattedDataVencimento = dataVencimentoParcela
          .toISOString()
          .split("T")[0];

        const newRow = `
        <tr>
          <td>${i + 1}</td>
          <td>${formattedValorParcela}</td>
          <td>${formattedDataVencimento}</td>
        </tr>
      `;
        $("#pagamento tbody").append(newRow);
      }

      $("#salvar").attr("disabled", false);
    });
  }

  async sendDataToAPI() {
    $(document).on("click", "#salvar", async function () {
      try {
        const itensData = [];
        $("#itens tbody tr").each(function () {
          const item = {
            id: $(this).data("id"),
            produto: $(this).find("td:nth-child(2)").text(),
            cliente: $(this).find("td:nth-child(3)").text(),
            vendedor: $(this).find("td:nth-child(4)").text(),
            quantidade: $(this).find("td:nth-child(5)").text(),
            valorUnitario: $(this).find("td:nth-child(6)").text(),
            subtotal: $(this).find("td:nth-child(7)").text(),
          };
          itensData.push(item);
        });

        const pagamentoData = [];
        $("#pagamento tbody tr").each(function () {
          const parcela = {
            numero: $(this).find("td:nth-child(1)").text(),
            valorParcela: $(this).find("td:nth-child(2)").text(),
            dataVencimento: $(this).find("td:nth-child(3)").text(),
          };
          pagamentoData.push(parcela);
        });

        const apiUrl = "./class/registerSales.php";

        const response = await fetch(apiUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            itens: itensData,
            parcelas: pagamentoData,
          }),
        });

        if (response.ok) {
          Swal.fire({
            icon: "success",
            title: "Registro realizado!",
            text: "Seu registro foi salvo com sucesso.",
          }).then((result) => {
            if (result.isConfirmed) location.reload();
          });
        } else {
          console.error("Erro ao enviar dados:", response.statusText);
        }
      } catch (error) {
        console.error("Erro durante o envio dos dados:", error);
      }
    });
  }
}
