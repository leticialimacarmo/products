$(window).on("load", async function () {
  const list = new List();
  await list.init();
});

class List {
  constructor() {
    this.id;
  }

  async init() {
    await this.initDatatable();
    this.printPDF();
    this.setupUpdateModal();
    this.deleteList();
  }

  async initDatatable() {
    if ($.fn.DataTable) {
      this.table = $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "./class/itensList.php",
          type: "POST",
          dataSrc: function (json) {
            return json.data;
          },
        },
        columns: [
          { data: "id" },
          { data: "tipoPagamento" },
          {
            data: "data_cadastro",
            render: function (data) {
              return data ? new Date(data).toLocaleDateString() : "";
            },
          },
          {
            data: null,
            render: function (data, type, row) {
              return `
                        <button type="button" class="btn btn-warning btn-sm update-btn" data-id="${row.id}" data-toggle="modal" data-target="#updateModal">
                            <i class="bi bi-pencil-square"></i> 
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">
                            <i class="bi bi-trash"></i> 
                        </button>
                    `;
            },
          },
        ],
      });
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

  setupUpdateModal() {
    const self = this;

    $(document).on("click", ".update-btn", async function (e) {
      e.preventDefault();

      const rowId = $(this).data("id");

      const response = await fetch(`./class/fetch.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id: rowId,
        }),
      });

      if (!response.ok) {
        throw new Error("Erro ao buscar dados");
      }

      const data = await response.json();

      data.data.forEach((item) => {
        this.id = item.id;
         const content = ` <tr>
               <td contenteditable="true" id="cliente_update">${item.cliente}</td>
               <td contenteditable="true" id="tipoPagamento_update">${item.tipoPagamento}</td>
               <td contenteditable="true" id="valorIntegral_update">${item.valorIntegral}</td>
             </tr>`;

         $("#updateModal tbody").append(content);
      });

      $("#updateModal").data("product-id", rowId);
    });

    $(document).on("click", "#update", async function (e) {
      e.preventDefault();

      const fieldsToValidate = [
        "nomeFantasia_update",
        "tipoPagamento_update",
        "valorIntegral_update",
      ];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateFieldUpdate(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const data = {
          id: this.id,
          nomeFantasia: $("#nomeFantasia_update").text(),
          razaoSocial: $("#tipoPagamento_update").text(),
          cpf: $("#valorIntegral_update").text(),
        };

        const apiUrl = `./class/updateList.php`;

        const requestOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        };

        fetch(apiUrl, requestOptions)
          .then((response) => response.json())
          .then((data) => {
            Swal.fire({
              icon: "success",
              title: "venda atualizada!",
              text: "Os dados da venda foram atualizados com sucesso.",
            }).then((result) => {
              if (result.isConfirmed) {
                $("#updateModal").modal("hide");
                location.reload();
              }
            });
          })
          .catch((error) => {
            console.error("Erro ao fazer requisição:", error);
          });

        $("#cliente_update").val("");
        $("#tipoPagamento_update").val("");
        $("#valorIntegral_update").val("");
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Preencha todos os campos obrigatórios antes de prosseguir.",
        });
      }
    });
  }

  deleteList() {
    const self = this;

    $(document).on("click", ".delete-btn", async function (e) {
      e.preventDefault();

      const productId = $(this).attr("data-id");

      const swalResponse = await Swal.fire({
        icon: "warning",
        title: "Tem certeza?",
        text: "Você está prestes a excluir esta venda.",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
      });

      if (swalResponse.isConfirmed) {
        const apiUrl = `./class/deleteList.php`;

        const requestOptions = {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id: productId,
          }),
        };

        fetch(apiUrl, requestOptions)
          .then((response) => response.json())
          .then((data) => {
            Swal.fire({
              icon: "success",
              title: "Venda excluída!",
              text: "A venda foi excluída com sucesso.",
            }).then((result) => {
              if (result.isConfirmed) location.reload();
            });
          })
          .catch((error) => {
            console.error("Erro ao fazer requisição:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Erro ao excluir a venda. Por favor, tente novamente mais tarde.",
            });
          });
      }
    });
  }

  printPDF() {
    const self = this;
    $(document).on("click", "#pdf", function () {
      const tableData = self.table.rows().data().toArray();

      const formattedData = tableData.map((row) => [
        row.id,
        row.cliente,
        row.tipoPagamento,
        row.valorIntegral,
        row.data_cadastro
          ? new Date(row.data_cadastro).toLocaleDateString()
          : "",
      ]);

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.autoTable({
        head: [
          [
            "ID",
            "Cliente",
            "Tipo de Pagamento",
            "Valor Integral",
            "Data de Cadastro",
          ],
        ],
        body: formattedData,
      });

      doc.save("List.pdf");
    });
  }
}
