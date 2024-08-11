$(document).ready(function () {
  // URL do arquivo PHP que retorna os dados
  const url = "conexão.php";
  const fetchDataUrl = "getData.php";
  // Função para preencher a tabela com dados
  function preencherTabela(dados) {
    const tbody = $("#usuarios-table tbody");
    tbody.empty(); // Limpa o corpo da tabela

    if (dados.length === 0) {
      tbody.html('<tr><td colspan="5">Nenhum usuário encontrado.</td></tr>');
      return;
    }

    dados.forEach((usuario) => {
      const tr = $("<tr></tr>");

      tr.html(`
          <td>${usuario.id}</td>
          <td>${usuario.nome}</td>
          <td>${usuario.email}</td>
          <td>${usuario.senha}</td>
          <td>${usuario.data_criacao}</td>
        `);

      tbody.append(tr);
    });
  }

  // Função para buscar usuários
  function buscarUsuarios(id) {
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      data: { id: id },
      success: function (data) {
        if (data.error) {
          console.error("Erro ao carregar dados:", data.error);
          $("#usuarios-table tbody").html(
            '<tr><td colspan="5">Erro ao carregar dados.</td></tr>'
          );
        } else {
          preencherTabela(data);
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro na requisição:", error);
        console.log("Detalhes do erro:", xhr.responseText);
        $("#usuarios-table tbody").html(
          '<tr><td colspan="5">Erro na requisição.</td></tr>'
        );
      },
    });
  }

  // Evento do botão de busca
  $("#search-button").click(function () {
    const id = $("#search-id").val();
    if (id) {
      buscarUsuarios(id);
    } else {
      // Se o ID não for fornecido, carregar todos os usuários
      buscarUsuarios("");
    }
  });
  $("#teste").click(function () {
    alert("Olá");
  });

  // Carregar todos os usuários inicialmente
  buscarUsuarios("");
  $("#fetch-data-button").click(function () {
    $.ajax({
      url: fetchDataUrl,
      method: "GET",
      dataType: "json",
      success: function (data) {
        if (data.error) {
          console.error("Erro ao carregar dados:", data.error);
          $("#data-popup-content").html("<p>Erro ao carregar dados.</p>");
        } else {
          // Supondo que `data` é um array com objetos contendo `nome` e `valor`
          const fragmento = data
            .map((dado) => `<p>Nome: ${dado.nome}, Valor: ${dado.email}</p>`)
            .join("");
          $("#data-popup-content").html(fragmento);
          $("#data-popup").show(); // Exibe o pop-up
        }
      },
      error: function (xhr, status, error) {
        console.error("Erro na requisição:", error);
        $("#data-popup-content").html("<p>Erro na requisição.</p>");
      },
    });
  }),
    $("#close-popup").click(function () {
      $("#data-popup").hide(); // Oculta o pop-up
    });
});
