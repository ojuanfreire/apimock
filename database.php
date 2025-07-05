<?php
$users = [
    [
        "id" => "84",
        "nome" => "Juan Freire",
        "password" => "consultor123",
        "email" => "juan.freire@ufv.br",
        "picture" => "url_da_foto_do_juan.jpg",
        "profile" => "Consultor",
        "supervisorId" => "85",
        "consultantIds" => null
    ],
    [
        "id" => "85",
        "nome" => "Pedro Moura",
        "password" => "supervisor123",
        "email" => "pedro.moura2@ufv.br",
        "picture" => "url_da_foto_do_pedro.jpg",
        "profile" => "Supervisor",
        "supervisorId" => null,
        "consultantIds" => ["84", "86"]
    ],
    [
        "id" => "86",
        "nome" => "Pedro Carvalho",
        "password" => "consultor456",
        "email" => "pedro.carvalho3@ufv.br",
        "picture" => "url_da_foto_do_pedro.jpg",
        "profile" => "Consultor",
        "supervisorId" => "85",
        "consultantIds" => null
    ]
];

$commissionRules = [
    [
        "id" => "1",
        "processId" => "1",
        "stage" => "Matriculado",
        "name" => "Comissão por Matrícula Direta",
        "description" => "Gera comissão quando um aluno é matriculado.",
        "assignedConsultantIds" => ["84", "86"],
        "ruleType" => "Percentual Fixo",
        "commissionPercentage" => 15.0
    ],
    [
        "id" => "2",
        "processId" => "3",
        "stage" => "Venda Concluída",
        "name" => "Comissão por Venda de Curso Livre",
        "description" => "Gera comissão quando um curso livre é vendido.",
        "assignedConsultantIds" => ["84", "85", "86"],
        "ruleType" => "Percentual Fixo",
        "commissionPercentage" => 20.0
    ]
];

$goals = [
    [
        "id" => "1",
        "assignedConsultantIds" => ["84", "86"],
        "description" => "Vender 20 produtos no trimestre",
        "goalValue" => 20000.0,
        "bonus" => 50.0,
        "achieved" => false
    ],
    [
        "id" => "2",
        "assignedConsultantIds" => ["84", "86"],
        "description" => "Vender 40 produtos no trimestre",
        "goalValue" => 24000.0,
        "bonus" => 100.0,
        "achieved" => true
    ],
    [
        "id" => "3",
        "assignedConsultantIds" => ["84", "86"],
        "description" => "Vender 100 produtos no trimestre",
        "goalValue" => 30000.0,
        "bonus" => 200.0,
        "achieved" => true
    ],
    [
        "id" => "4",
        "assignedConsultantIds" => ["84", "86"],
        "description" => "Vender 10 produtos no trimestre",
        "goalValue" => 1000.0,
        "bonus" => 20.0,
        "achieved" => false
    ],
    [
        "id" => "5",
        "assignedConsultantIds" => ["85"],
        "description" => "Atingir R$50.000 em faturamento da equipe",
        "goalValue" => 50000.0,
        "bonus" => 1000.0,
        "achieved" => true
    ]
];
?>