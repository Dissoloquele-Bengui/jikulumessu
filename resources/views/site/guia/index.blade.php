<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Guia de Pagamento para Agendamento de Consulta</title>
  <style>
    /* CSS original */
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    /* CSS adicional */
    h1 {
      color: #444;
      font-size: 1.8em;
      font-weight: bold;
    }
    h2 {
      color: #666;
      font-size: 1.6em;
      font-weight: bold;
    }
    h1 {
  color: #444;
  font-size: 1.8em;
  font-weight: bold;
}

h2 {
  color: #666;
  font-size: 1.6em;
  font-weight: bold;
}

ul, ol {
  list-style-type: none;
  padding: 10px;
}

li {
  padding: 5px 0;
  border-bottom: 1px solid #ddd;
}

a {
  color: #0073b7;
  text-decoration: underline;
}

a:hover {
  color: #004d80;
}

.container {
  width: 80%;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid #ddd;
  padding: 20px;
}

.assinatura {
  text-align: right;
  margin-top: 20px;
}

.data-hora {
  font-style: italic;
  font-size: 0.9em;
  color: #999;
}

.codigo-agendamento {
  font-size: 1.2em;
  font-weight: bold;
  text-align: center;
  margin-top: 10px;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>Guia de Pagamento para Agendamento de Consulta</h1>

    <h2>Dados da Consulta</h2>

    <ul>
      <li>Paciente: {{Auth::user()->name}}</li>
      <li>Especialidade: {{$medico->especializacao}}</li>
      <li>Data: {{$guia->dia}}</li>
      <li>Horário: {{$guia->hora_inicio."-".$guia->hora_termino}}</li>
      <li>Local: {{$guia->hospital}}</li>
      <li>Médico: {{$guia->medico}}</li>
    </ul>

    <h2>Valor da Consulta</h2>

    <p>{{$guia->preco}}</p>

    <h2>Forma de Pagamento</h2>

    <ul>
      <li><a href="[Link para gerar boleto bancário]">Boleto Bancário</a></li>
      <li><a href="[Link para formulário de pagamento com cartão de crédito]">Cartão de Crédito</a></li>
    </ul>

    <h2>Instruções</h2>

    <ol>
      <li>Escolha a forma de pagamento desejada.</li>
      <li>Efetue o pagamento do valor da consulta.</li>
      <li>Envia o comprovante de pagamento apartir do sistema.</li>
    </ol>

    <h2>Observações</h2>

    <ul>
      <li>O agendamento da consulta só será confirmado após a efetivação do pagamento.</li>
      <li>Em caso de dúvidas, entre em contato com a clínica ou hospital pelo telefone +244 958070350 ou pelo e-mail SASS@gmail.com.</li>
    </ul>

    <h2 class="codigo-agendamento">Coordenadas Bancárias</h2>

    <p class="codigo-agendamento">{{isset($hospital->iban)?$hospital->iban:"AO06454545454451"}}</p>

    <h2 class="data-hora">Gerado em</h2>

    <p class="data-hora">[Data e Hora]</p>

    <div class="assinatura">
      <p>___________________________________</p>
      <p>[Nome da Clínica ou Hospital]</p>
    </div
