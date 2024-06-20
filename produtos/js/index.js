$(window).on("load", async function () {
  const products = new Products();
  await products.init();
});

class Products {
  constructor() {}

  async init() {
    await this.initDatatable();
    this.formatValues();
    this.registerProducts();
    this.setupUpdateModal();
    this.deleteProducts();

    $("#codigo").val("");
    $("#descricao").val("");
    $("#valor").val("");
    $("#fornecedor").val("");
  }

  async initDatatable() {
    const self = this;
    if ($.fn.DataTable) {
      self.table = $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "./class/getProducts.php",
          type: "POST",
          dataSrc: function (json) {
            return json.data;
          },
        },
        columns: [
          { data: "id", visible: false },
          { data: "codigo" },
          { data: "descricao" },
          { data: "valor" },
          { data: "fornecedor" },
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



  registerProducts() {
    const self = this;

    $(document).on("click", "#register", async function (e) {
      e.preventDefault();

      const fieldsToValidate = ["codigo", "descricao", "valor", "fornecedor"];

      const validations = fieldsToValidate.map((fieldName) =>
        self.validateField(fieldName)
      );

      if (validations.every((valid) => valid)) {
        const data = {
          codigo: $("#codigo").val(),
          descricao: $("#descricao").val(),
          valor: $("#valor").val(),
          fornecedor: $("#fornecedor").val(),
        };

        const apiUrl = `./class/registerProduct.php`;

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
              title: "Registro realizado!",
              text: "Seu registro foi salvo com sucesso.",
            }).then((result) => {
              if (result.isConfirmed) location.reload();
            });
          })
          .catch((error) => {
            console.error("Erro ao fazer requisição:", error);
          });

        $("#codigo").val("");
        $("#descricao").val("");
        $("#valor").val("");
        $("#fornecedor").val("");
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

      $("#codigo_update").val(rowData.codigo);
      $("#descricao_update").val(rowData.descricao);
      $("#valor_update").val(rowData.valor);
      $("#fornecedor_update").val(rowData.fornecedor);
      $("#updateModal").data("product-id", rowId);
    });

    $(document).on("click", "#update", async function (e) {
  
        const data = {
          id: $("#updateModal").data("product-id"),
          codigo: $("#codigo_update").val(),
          descricao: $("#descricao_update").val(),
          valor: $("#valor_update").val(),
          fornecedor: $("#fornecedor_update").val(),
        };

        const apiUrl = `./class/updateProduct.php`;

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
              title: "Produto atualizado!",
              text: "Os dados do produto foram atualizados com sucesso.",
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

        $("#codigo_update").val("");
        $("#descricao_update").val("");
        $("#valor_update").val("");
        $("#fornecedor_update").val("");
    
    });
  }

  deleteProducts() {
    const self = this;

    $(document).on("click", ".delete-btn", async function (e) {
      e.preventDefault();

      const productId = $(this).attr("data-id");
      const id = productId;

      const swalResponse = await Swal.fire({
        icon: "warning",
        title: "Tem certeza?",
        text: "Você está prestes a excluir este produto.",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
      });

      if (swalResponse.isConfirmed) {
        const apiUrl = `./class/deleteProduct.php`;

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
              title: "Produto excluído!",
              text: "O produto foi excluído com sucesso.",
            }).then((result) => {
              if (result.isConfirmed) location.reload();
            });
          })
          .catch((error) => {
            console.error("Erro ao fazer requisição:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Erro ao excluir o produto. Por favor, tente novamente mais tarde.",
            });
          });
      }
    });
  }
}
