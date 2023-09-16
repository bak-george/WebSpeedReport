<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com" ></script>
    <title>WebSpeedReport</title>
</head>
<body>
    <main>
        <section class="flex items-center justify-center min-h-screen bg-cyan-50">
            <div class="flex flex-col items-start bg-white p-2 m-2 space-y-10 shadow-2xl rounded-3xl md:p-40">
                <h1 class="text-2xl">Web Speed Report</h1>
                <table class="table-fixed">
                    <thead>
                    <tr>
                        <th class="px-4">Timestamp</th>
                        <th class="px-4">Download BandWidth (Kb/s)</th>
                        <th class="px-4">Download Bytes (Mb)</th>
                        <th class="px-4">Upload BandWidth (Kb/s)</th>
                        <th class="px-4">Upload Bytes (Mb)</th>
                    </tr>
                    </thead>
                    <tbody class="m-4">
                    <?php
                        foreach ($data as $row) {
                                echo "<tr>";
                                echo "<td class='px-4'>" . htmlspecialchars($row['timestamp']) . "</td>";
                                echo "<td class='px-4'>" . htmlspecialchars($row['download_bandwidth']) . "</td>";
                                echo "<td class='px-4'>" . htmlspecialchars($row['download_bytes']) . "</td>";
                                echo "<td class='px-4'>" . htmlspecialchars($row['upload_bandwidth']) . "</td>";
                                echo "<td class='px-4'>" . htmlspecialchars($row['upload_bytes']) . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>