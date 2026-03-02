<?php
include "C:\wamp64\www\Prestamos\connect.php";
$result = $conn->query("SELECT * FROM cartas ORDER BY id_carta DESC");
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="cartas.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GolTickets - Cartas</title>
</head>
<body>

    <nav class="sidebar">
       <div class="sidebar-title">Menu</div>
        <a href="..\index.php" class="nav-link">🏠 Inicio</a>
        <a href="..\personas\personas.php" class="nav-link">👤 Personas</a>
        <a href="..\cartas\cartas.php" class="nav-link active">🃏 Cartas</a>
        <a href="..\prestamos\prestamos.php" class="nav-link">💳 Prestamos</a>
    </nav>

    <main class="contenido">
        <h2>CARTAS</h2>

        <div class="actions">
            <a href="createCarta.php" class="btn-crear">
                <span class="icon">➕</span>
                <span class="text">Añadir una carta</span>
            </a>
        </div>

        <table id="tablaCartas">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th onclick="ordenarTabla(1)">Carta ↕</th>
                    <th onclick="ordenarTabla(2)">Tipo ↕</th>
                    <th onclick="ordenarTabla(3)">Rareza ↕</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><img src="<?= $row['imagen_url'] ?>" alt="<?= $row['nombre'] ?>"></td>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['tipo'] ?></td>
                        <td><?= $row['rareza'] ?></td>
                        <td>
                            <a href="edit.php?id_carta=<?= $row['id_carta'] ?>">✏️</a>
                            <a href="delete.php?id_carta=<?= $row['id_carta'] ?>" onclick="return confirm('Eliminar?')">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        let orden = {};

        const ordenRareza = {
            "common": 1,
            "uncommon": 2,
            "rare": 3,
            "epic": 4
        };

        function ordenarTabla(col) {
            const tabla = document.getElementById("tablaCartas").querySelector("tbody");
            const filas = Array.from(tabla.querySelectorAll("tr"));

            orden[col] = !orden[col];

            filas.sort((a, b) => {
                const textoA = a.cells[col].innerText.toLowerCase();
                const textoB = b.cells[col].innerText.toLowerCase();

                if (col === 3) {
                    const valA = ordenRareza[textoA] ?? 99;
                    const valB = ordenRareza[textoB] ?? 99;
                    return orden[col] ? valA - valB : valB - valA;
                }

                if (textoA < textoB) return orden[col] ? -1 : 1;
                if (textoA > textoB) return orden[col] ? 1 : -1;
                return 0;
            });

            filas.forEach(fila => tabla.appendChild(fila));
        }
    </script>

</body>
</html>