$(window).on("load", async function () {
  const clients = new Clients();
  await clients.init();
});

class Clients {
  constructor() {}

  async init() {
    await this.initDatatable();
    this.registerClients();
    this.setupUpdateModal();
    this.deleteclients();
  }

  async initDatatable() {
    const self = this;
    if ($.fn.DataTable) {
      self.table = $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "./class/itensClient.php",
          type: "POST",
          dataSrc: function (json) {
            return json.data;
          },
        },
        columns: [
          { data: "id", visible: false },
          { data: "nomeFantasia" },
          { data: "razaoSocial" },
          { data: "cpf" },
          { data: "cidade" },
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

  formatValues() {
    $("#valor").on("input", function (event) {
      let value = $(this).val();
      value = value.replace(/\D/g, "");
      let formatted = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(value / 100);
      $(this).val(formatted);
    });
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

  registerClients() {
    const self = this;

    $(document).on("click", "#register", async function (e) {
      e.preventDefault();

      const fieldsToValidate = ["nomeFantasia", "razaoSocial", "cpf", "cidade"];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateField(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const data = {
          nomeFantasia: $("#nomeFantasia").val(),
          razaoSocial: $("#razaoSocial").val(),
          cpf: $("#cpf").val(),
          cidade: $("#cidade").val(),
        };

        const apiUrl = `./class/registerClient.php`;

        const requestOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        };

        try {
          const response = await fetch(apiUrl, requestOptions);
          if (!response.ok) {
            throw new Error("Erro ao tentar cadastrar o cliente.");
          }

          const responseData = await response.json();

          Swal.fire({
            icon: "success",
            title: "Registro realizado!",
            text: "Seu registro foi salvo com sucesso.",
          }).then((result) => {
            if (result.isConfirmed) location.reload();
          });

          $("#nomeFantasia").val("");
          $("#razaoSocial").val("");
          $("#cpf").val("");
          $("#cidade").val("");
        } catch (error) {
          console.error("Erro ao fazer requisição:", error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Erro ao tentar cadastrar o cliente. Por favor, tente novamente mais tarde.",
          });
        }
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Preencha todos os campos obrigatórios antes de prosseguir.",
        });
      }
    });
  }

  setupUpdateModal() {
    const self = this;

    $(document).on("click", ".update-btn", function (e) {
      e.preventDefault();

      const rowId = $(this).data("id");
      const rowData = self.table.row($(this).closest("tr")).data();

      $("#nomeFantasia_update").val(rowData.nomeFantasia);
      $("#razaoSocial_update").val(rowData.razaoSocial);
      $("#cpf_update").val(rowData.cpf);
      $("#cidade_update").val(rowData.cidade);
      $("#updateModal").data("product-id", rowId);
    });

    $(document).on("click", "#update", async function (e) {
      e.preventDefault();

      const fieldsToValidate = [
        "nomeFantasia_update",
        "razaoSocial_update",
        "cpf_update",
        "cidade_update",
      ];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateFieldUpdate(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const data = {
          id: $("#updateModal").data("product-id"),
          nomeFantasia: $("#nomeFantasia_update").val(),
          razaoSocial: $("#razaoSocial_update").val(),
          cpf: $("#cpf_update").val(),
          cidade: $("#cidade_update").val(),
        };

        const apiUrl = `./class/updateClient.php`;

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
              title: "Cliente atualizado!",
              text: "Os dados do cliente foram atualizados com sucesso.",
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

        $("#nomeFantasia_update").val("");
        $("#razaoSocial_update").val("");
        $("#cpf_update").val("");
        $("#cidade_update").val("");
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Preencha todos os campos obrigatórios antes de prosseguir.",
        });
      }
    });
  }

  deleteclients() {
    const self = this;

    $(document).on("click", ".delete-btn", async function (e) {
      e.preventDefault();

      const productId = $(this).attr("data-id");
      const id = productId;

      const swalResponse = await Swal.fire({
        icon: "warning",
        title: "Tem certeza?",
        text: "Você está prestes a excluir este cliente.",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
      });

      if (swalResponse.isConfirmed) {
        const apiUrl = `./class/deleteClient.php`;

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
              title: "Cliente excluído!",
              text: "O cliente foi excluído com sucesso.",
            }).then((result) => {
              if (result.isConfirmed) location.reload();
            });
          })
          .catch((error) => {
            console.error("Erro ao fazer requisição:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Erro ao excluir o cliente. Por favor, tente novamente mais tarde.",
            });
          });
      }
    });
  }
}
