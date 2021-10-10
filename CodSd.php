<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Sudoku">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sudoku</title>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <style type="text/css">
        body {
            background: #F0FFF0 !important;
        }

        input[type='text']:enabled {
            background: #FFFFFF;
            font-size: 35px;
            text-align: center;
        }

        input[type='text']:disabled {
            background: #FFFFFF;
            color: blue;
            font-size: 35px;
            text-align: center;
        }

    /* Cor bot lista */
.baixlis {
    background-color: #3498DB;
    color: white;
    padding: 10px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    height: 50px;
    width: 150px;
}

    /* Passe */
    .baixlis:hover, .baixlis:focus {
        background-color: #2980B9;
    }

.numlis {
    background-color: #DB7734;
    color: white;
    padding: 10px;
    font-size: 30px;
    border: none;
    cursor: pointer;
    height: 70px;
    width: 75px;
    margin-bottom: 5px;
}

.dropdown {
    position: relative;
    display: inline-block;
    margin-top: 20px;
    margin-bottom: 10px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    right: 0;
    z-index: 1;
}

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

        /* Cor do texto */
        .dropdown-content a:hover {
            background-color: #ddd
        }

/* Menu de dropdown*/
.show {
    display: block;
}

.cell {
    width: 50px;
    height: 50px;
}

.excell {
    width: 50px;
    height: 50px;
}

    </style>
</head>
<body>
<div class="c-content-box c-size-md c-no-bottom-padding">
            <div class="container">
                <div class="c-content-bar-3">

    <div align="center">

        <div>
            <h1>Sudoku</h1>
        </div>

        <div id="table">


        </div>

        <fieldset id="field1" style="width: 300px; position: absolute; right: 150px; top: 200px; border-color: transparent; background-color: #3498DB; display: none">
            <button onclick="foc(1)" class="numlis">1</button>
            <button onclick="foc(2)" class="numlis">2</button>
            <button onclick="foc(3)" class="numlis">3</button>
            <button onclick="foc(4)" class="numlis">4</button>
            <button onclick="foc(5)" class="numlis">5</button>
            <button onclick="foc(6)" class="numlis">6</button>
            <button onclick="foc(7)" class="numlis">7</button>
            <button onclick="foc(8)" class="numlis">8</button>
            <button onclick="foc(9)" class="numlis">9</button>
            <input id="foc" type="text" class="numlis" value="" style="font-size: 75px;" disabled>
        </fieldset>

        <div>
            <div class="dropdown">
                <button onclick="lis()" class="baixlis">Dificuldade</button>
                <div id="lis" class="dropdown-content">
                    <a href="#" onclick="prinfun(1)">Fácil</a>
                    <a href="#" onclick="prinfun(2)">Médio</a>
                    <a href="#" onclick="prinfun(3)">Difícil</a>
                </div>
            </div>

            <button id="but1" onclick="res(1)" class="baixlis" style="display: none">Resposta</button>
            <button id="but1.5" onclick="res(2)" class="baixlis" style="display: none">Tentativa</button>
            <button id="but2" onclick="dic(1)" class="baixlis" style="display: none">Indicar Erros</button>
            <button id="but2.5" onclick="dic(2)" class="baixlis" style="display: none">Apagar Indicação</button>
            <button id="but3" onclick="res(3)" class="baixlis" style="display: none">Confirma</button>

        </div>
        <input type="text" id="text" value="" readonly>
    </div>


        </div>
            </div>
        </div>
    <script>
        function lis() {
            document.getElementById("lis").classList.toggle("show");
        }

        // Fechar se clickar fora
        window.onclick = function (event) {
            if (!event.target.matches(".baixlis")) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains("show")) {
                        openDropdown.classList.remove("show");
                    }
                }

            }

        };

        document.onclick = function () {
            document.getElementById("table").onclick = foc(0);
        };

        function foc(ax1) {
            var ax2;
            if (ax1 == 0) {
                ax1 = document.getElementById("foc").getAttribute("value");
                if (ax1 == document.activeElement.getAttribute("value"))
                    document.activeElement.setAttribute("value", "");
                else
                    document.activeElement.setAttribute("value", ax1);
                return;
            }
            else document.getElementById("foc").setAttribute("value", ax1);
        }

var _numeSet = [
    [7, 9, 2, 3, 5, 1, 8, 4, 6],
    [4, 6, 8, 9, 2, 7, 5, 1, 3],
    [1, 3, 5, 6, 8, 4, 7, 9, 2],
    [6, 2, 1, 5, 7, 9, 4, 3, 8],
    [5, 8, 3, 2, 4, 6, 1, 7, 9],
    [9, 7, 4, 8, 1, 3, 2, 6, 5],
    [8, 1, 6, 4, 9, 2, 3, 5, 7],
    [3, 5, 7, 1, 6, 8, 9, 2, 4],
    [2, 4, 9, 7, 3, 5, 6, 8, 1],
],
    _problemSet = [
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
    ],
    _problemCopy = [
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
        [],
    ],
    _originalSet = [
        [7, 9, 2, 3, 5, 1, 8, 4, 6],
        [4, 6, 8, 9, 2, 7, 5, 1, 3],
        [1, 3, 5, 6, 8, 4, 7, 9, 2],
        [6, 2, 1, 5, 7, 9, 4, 3, 8],
        [5, 8, 3, 2, 4, 6, 1, 7, 9],
        [9, 7, 4, 8, 1, 3, 2, 6, 5],
        [8, 1, 6, 4, 9, 2, 3, 5, 7],
        [3, 5, 7, 1, 6, 8, 9, 2, 4],
        [2, 4, 9, 7, 3, 5, 6, 8, 1],
    ];

function prinfun(difi) {
    const maxLins = 9;
    const maxCols = 9;
    const caixLins = 3;
    const caixCols = 3;
    var i, j;

    function randax2a() {
        return Math.floor(Math.random() * (2 + 1));  //0 to 2
    }

    function randax3a() {
        return Math.floor(Math.random() * (3 + 1));  //0 to 3
    }

    function randax3b() {
        return Math.floor(Math.random() * (3 - 1 + 1)) + 1;  //1 to 3
    }

    function randax8a() {
        return Math.floor(Math.random() * (8 + 1));  //0 to 8
    }

    Iniciarnum();
    // Copia dos números
    _problemCopy = _problemSet;
    FDaset();

    // Controla a responsividade das celulas

    for (i = 0; i < maxLins; i++) {
        for (j = 0; j < maxCols; j++) {

            if (document.getElementById(i + "" + j).value != 0) {
                document.getElementById(i + "" + j).disabled = true;
            } else document.getElementById(i + "" + j).readOnly = true;

        }
    }

    // Tornar botões visiveis
    var link = document.getElementById('but1');
    link.style.display = 'inline';
    link = document.getElementById('but1.5');
    link.style.display = 'none';
    link = document.getElementById('but2');
    link.style.display = 'inline';
    link = document.getElementById('but2.5');
    link.style.display = 'inline';
    link = document.getElementById('but3');
    link.style.display = 'inline';
    link = document.getElementById('field1');
    link.style.display = 'inline';

    document.getElementById("text").value = "";

    return;

    // Gera numeros

    function Iniciarnum() {

        var r, e, w, pat;

        for (i = 0; i < maxLins; i++) {
            for (j = 0; j < maxCols; j++) {

                _numeSet[i][j] = _originalSet[i][j];
            }
        }

        Trocnum(); //trocas

        for (j = 0; j <= 4 + difi; j++) {   // Torna em zeros
            _problemSet[randax2a()][randax8a()] = 0;
            _problemSet[randax2a() + 3][randax8a()] = 0;
            _problemSet[randax2a() + 5][randax8a()] = 0;

        }

        // Da numero a celula central
        if (difi == 2) {
            r = randax3b();
            if (r == 1)
                e = 0;
            else if (r == 2)
                e = 3;
            else e = 6;
            for (j = 0 + e; j < caixCols + e; j++) {
                for (i = 0; i < caixLins; i++) {
                    _problemSet[i][j] = 0;
                }
            }
            _problemSet[1][e + 1] = _numeSet[1][e + 1];

            r = randax3b();
            if (r == 1)
                e = 0;
            else if (r == 2)
                e = 3;
            for (j = 0 + e; j < caixCols + e; j++) {
                for (i = 6; i < 9; i++) {
                    _problemSet[i][j] = 0;
                }
            }
            _problemSet[7][e + 1] = _numeSet[7][e + 1];
        }

        // Cria as caixas vazias e garante que não ha colunas
        if (difi == 3) {
            r = randax3b();
            if (r == 1)
                w = 0;
            else if (r == 2)
                w = 3;
            else w = 6;
            for (j = 0 + w; j < caixCols + w; j++) {
                for (i = 0; i < caixLins; i++) {
                    _problemSet[i][j] = 0;
                }
            }
            _problemSet[1][w + 1] = _numeSet[1][w + 1];

            r = randax3b();
            if (r == 1)
                e = 0;
            else if (r == 2)
                e = 3;
            else e = 6;
            for (j = 0 + e; j < caixCols + e; j++) {
                for (i = 6; i < 9; i++) {
                    _problemSet[i][j] = 0;
                }
            }
            _problemSet[7][e + 1] = _numeSet[7][e + 1];

            if (w == 6 && e == 6) {
                for (j = 0; j < 3; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 1;
            }
            else if (w == 6 && e == 3) {
                for (j = 0; j < 3; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 0; i < 3; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 2;
            }
            else if (w == 6 && e == 0) {
                for (j = 0; j < 3; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 3;
            }
            else if (w == 3 && e == 6) {
                for (j = 6; j < 9; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 4;
            }
            else if (w == 3 && e == 3) {
                for (j = 0; j < 3; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 5;
            }
            else if (w == 3 && e == 0) {
                for (j = 0; j < 3; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 6; j < 9; j++) {
                    for (i = 6; i < 9; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 6;
            }
            else if (w == 0 && e == 6) {
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 3; j < 6; j++) {
                    for (i = 6; i < 9; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 7;
            }
            else if (w == 0 && e == 3) {
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 0; j < 3; j++) {
                    for (i = 6; i < 9; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 8;
            }
            else if (w == 0 && e == 0) {
                for (j = 3; j < 6; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                for (j = 6; j < 9; j++) {
                    for (i = 3; i < 6; i++) {
                        _problemSet[i][j] = 0;
                    }
                }
                pat = 9;
            }

            // Da numero a celula central
            if (pat == 1) {
                _problemSet[4][1] = _numeSet[4][1];
                _problemSet[4][4] = _numeSet[4][4];
            }
            if (pat == 2) {
                _problemSet[4][1] = _numeSet[4][1];
                _problemSet[1][4] = _numeSet[1][4];
            }
            if (pat == 3) {
                _problemSet[4][1] = _numeSet[4][1];
                _problemSet[4][4] = _numeSet[4][4];
            }
            if (pat == 4) {
                _problemSet[4][7] = _numeSet[4][7];
                _problemSet[4][4] = _numeSet[4][4];
            }
            if (pat == 5) {
                _problemSet[4][1] = _numeSet[4][1];
                _problemSet[4][4] = _numeSet[4][4];
            }
            if (pat == 6) {
                _problemSet[4][1] = _numeSet[4][1];
                _problemSet[7][7] = _numeSet[7][7];
            }
            if (pat == 7) {
                _problemSet[4][4] = _numeSet[4][4];
                _problemSet[7][4] = _numeSet[7][4];
            }
            if (pat == 8) {
                _problemSet[4][4] = _numeSet[4][4];
                _problemSet[7][1] = _numeSet[7][1];
            }
            if (pat == 9) {
                _problemSet[4][4] = _numeSet[4][4];
                _problemSet[4][7] = _numeSet[4][7];
            }

        }
    }

    // Troca localização de numeros

    function Trocnum() {

        var y1 = 2, y2 = 2, temp, j, i, r = 0;

        //caix

        do {
            if (y1 == 2)
                for (j = 0; j < maxCols; j++) {
                    for (i = 1; i < (caixLins + 1); i++) {
                        temp = _numeSet[-1 + i][j];
                        _numeSet[-1 + i][j] = _numeSet[2 + i][j];
                        _numeSet[2 + i][j] = temp;

                    }
                }

            if (y2 == 2)
                for (j = 0; j < maxCols; j++) {
                    for (i = 1; i < (caixLins + 1); i++) {
                        temp = _numeSet[2 + i][j];
                        _numeSet[2 + i][j] = _numeSet[5 + i][j];
                        _numeSet[5 + i][j] = temp;

                    }
                }

            y1 = randax3a();
            y2 = randax3a();
            r++;
        } while (r < 3);

        r = 0;
        y1 = 2;

        //lin

        do {

            if (y1 == 2)
                for (i = 0; i < maxLins; i++) {
                    for (j = 0; j < 6; j++) {
                        temp = _numeSet[i][j];
                        if (j < 6) {
                            _numeSet[i][j] = _numeSet[i][j + 3];
                            _numeSet[i][j + 3] = temp;
                        }
                    }
                }

            if (y1 != 2)
                for (j = 0; j < maxCols; j++) {
                    for (i = 1; i < (caixLins + 1); i++) {
                        temp = _numeSet[2 + i][j];
                        _numeSet[2 + i][j] = _numeSet[5 + i][j];
                        _numeSet[5 + i][j] = temp;
                    }
                }
            y1 = randax3a();
            r++;
        } while (r < 3);


        for (i = 0; i < maxCols; i++) {
            for (j = 0; j < maxLins; j++) {
                _problemSet[i][j] = _numeSet[i][j];
            }
        }
    }


    // numeSet é a solução unica
    // problemset são numeros revelados
    // problemCopy é para prevenir a sua mudança
    // cria a tabela

    function FDaset() {
        var tbl = document.createElement('table');

        tbl.style.width = '400px';
        tbl.style.height = '400px';
        tbl.style.border = '1px solid black';

        for (i = 0; i < maxLins; i++) {
            var tr = tbl.insertRow();
            var x;
            for (j = 0; j < maxCols; j++) {
                {
                    var td = tr.insertCell();
                    if (_problemSet[i][j] == 0) {
                        x = document.createElement("INPUT");
                        x.setAttribute("type", "text");
                        x.setAttribute("id", i + "" + j);
                        x.setAttribute("class", "cell");
                        x.setAttribute("value", "");
                        td.appendChild(document.body.appendChild(x));
                    }

                    else {
                        x = document.createElement("INPUT");
                        x.setAttribute("type", "text");
                        x.setAttribute("id", i + "" + j);
                        x.setAttribute("class", "excell");
                        x.setAttribute("value", _problemSet[i][j]);
                        td.appendChild(document.body.appendChild(x));
                    }

                    if (i <= 2) {
                        if (j < 3) {
                            td.style.border = '2px solid red';
                            td.style.backgroundColor = "red";
                            x.style.background = "red";
                        }
                        if (j > 2 && j <= 5) {
                            td.style.border = '2px solid yellow';
                            td.style.backgroundColor = "yellow";
                            x.style.background = "lightyellow";
                        }
                        if (j > 5) {
                            td.style.border = '2px solid orange';
                            td.style.backgroundColor = "orange";
                            x.style.background = "coral";
                        }
                    }
                    if (i > 2 && i <= 5) {
                        if (j < 3) {
                            td.style.border = '2px solid blue';
                            td.style.backgroundColor = "blue";
                            x.style.background = "aliceblue";
                        }
                        if (j > 2 && j <= 5) {
                            td.style.border = '2px solid brown';
                            td.style.backgroundColor = "brown";
                            x.style.background = "goldenrod";
                        }
                        if (j > 5) {
                            td.style.border = '2px solid pink';
                            td.style.backgroundColor = "pink";
                            x.style.background = "lightpink";
                        }
                    }
                    if (i > 5) {
                        if (j < 3) {
                            td.style.border = '2px solid green';
                            td.style.backgroundColor = "green";
                            x.style.background = "lawngreen";
                        }
                        if (j > 2 && j <= 5) {
                            td.style.border = '2px solid purple';
                            td.style.backgroundColor = "purple";
                            x.style.background = "mediumorchid";
                        }
                        if (j > 5) {
                            td.style.border = '2px solid grey';
                            td.style.backgroundColor = "grey";
                            x.style.background = "gainsboro";
                        }
                    }
                }
            }
        }
        document.getElementById("table").appendChild(tbl);

        var re = document.getElementById("table");

        re.removeChild(re.firstChild);
        return;
    }
}

// Acaba a criação de tabela
// Começa as resposta e confirmação

function res(ax1) {
    var i = 0, j = 0, link, ceid, cecla;
    if (ax1 == 1) {

        // Revela os numeros
        do {
            document.getElementById(i + "" + j).setAttribute("value", _numeSet[i][j]);
            i++;
            if (i == 9) {
                j++;
                i = 0;
            }
        }
        while (j != 9);
        link = document.getElementById('but1');
        link.style.display = 'none';
        link = document.getElementById('but1.5');
        link.style.display = 'inline';
        dic(2);
    }

    if (ax1 == 2) {

        // Tenta outra vez
        do {
            ceid = document.getElementById(i + "" + j);
            if (ceid == undefined) {
                document.getElementById("text").value = "Precisa de iniciar tabela";
                break;
            }

            cecla = ceid.className;
            switch (cecla) {

                case "cell":
                    document.getElementById(i + "" + j).setAttribute("value", "");
            }
            i++;
            if (i == 9) {
                j++;
                i = 0;
            }
        }
        while (j != 9);
        link = document.getElementById('but1.5');
        link.style.display = 'none';
        dic(2);
    }

    if (ax1 == 3) {

        // Informa se ha erros ou não
        var ver = true;
        i = 0;
        j = 0;
        do {
            if (document.getElementById(i + "" + j).value == _numeSet[i][j]) { }
            else ver = false;

            i++;
            if (i == 9) {
                j++;
                i = 0;
            }
            if (ver == true)
                document.getElementById("text").value = "Sucesso";
            else document.getElementById("text").value = "Fracasso";
        }
        while (j < 9);
    }
}

// Começa as dicas e da e retira cor as celulas


function dic(ax1) {
    var i = 0, j = 0, ax2;
    for (i = 0; i < 9; i++) {
        for (j = 0; j < 9; j++) {
            if (i <= 2) {
                if (j < 3) {
                    document.getElementById(i + "" + j).style.background = "red";
                }
                if (j > 2 && j <= 5) {
                    document.getElementById(i + "" + j).style.background = "lightyellow";
                }
                if (j > 5) {
                    document.getElementById(i + "" + j).style.background = "coral";
                }
            }
            if (i > 2 && i <= 5) {
                if (j < 3) {
                    document.getElementById(i + "" + j).style.background = "aliceblue";
                }
                if (j > 2 && j <= 5) {
                    document.getElementById(i + "" + j).style.background = "goldenrod";
                }
                if (j > 5) {
                    document.getElementById(i + "" + j).style.background = "lightpink";
                }
            }
            if (i > 5) {
                if (j < 3) {
                    document.getElementById(i + "" + j).style.background = "lawngreen";
                }
                if (j > 2 && j <= 5) {
                    document.getElementById(i + "" + j).style.background = "mediumorchid";
                }
                if (j > 5) {
                    document.getElementById(i + "" + j).style.background = "gainsboro";
                }
            }


            if (document.getElementById(i + "" + j).value != _numeSet[i][j] && document.getElementById(i + "" + j).value != "" && ax1 == 1) {
                document.getElementById(i + "" + j).style.background = 'gray';
                ax2 = 2
            } else if (ax2 != 2 && ax1 == 1) ax2 = 1
        }
    }
    if (ax2 == 2 && ax1 == 1)
        document.getElementById("text").value = "Erros Detetados";
    else if (ax2 == 1 && ax1 == 1)
        document.getElementById("text").value = "OK";
    else document.getElementById("text").value = "";
}



    </script>


</body>
</html>
