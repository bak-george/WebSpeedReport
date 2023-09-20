<?php require('partials/head.php'); ?>
<body class="bg-gray-100 font-mono">
    <main>
        <h1 class="text-6xl text-center">Web Speed Report</h1>
        <div class="container mx-auto max-w-8xl mb-20 md:p-10">
            <div class="grid gap-6 grid-cols-1 text-white md:grid-cols-4 md:grid-rows-2">
                <!--Box 1-->
                <div class="relative bg-blue-600 p-10 h-64 rounded-xl transition duration-300 ease-out hover:ease-in md:col-span-2 shadow-2xl hover:scale-105">
                    <div class="flex z-10 space-x-4">
                        <h1 class=" text-4xl text-black">Download(Mb)</h1>
                    </div>
                    <p class="mt-6 text-2xl">
                        Max: <?php echo $maxValues[0]; ?>
                    </p>
                    <p class="text-2xl">
                        Min: <?php echo $minValues[0]; ?>
                    </p>
                    <p class="absolute bottom-0 right-0 md:translate-y-4 md:translate-x-4 text-black text-8xl bg-gray-100 rounded-xl">
                        <?php echo $averages[0]; ?>
                    </p>
                </div>
                <!--Box 2-->
                <div class="relative bg-green-500 p-10 h-64 rounded-xl md:col-span-2 shadow-2xl transition duration-300 ease-out hover:scale-105">
                    <div class="flex z-10 space-x-4">
                        <h1 class="text-4xl text-black">Upload(Mb)</h1>
                    </div>
                    <p class="mt-6 text-2xl">
                        Max: <?php echo $maxValues[1]; ?>
                    </p>
                    <p class="text-2xl">
                        Min: <?php echo $minValues[1]; ?>
                    </p>
                    <p class="absolute bottom-0 right-0 md:translate-y-4 md:translate-x-4 text-black text-8xl bg-gray-100 rounded-xl">
                        <?php echo $averages[1]; ?>
                    </p>
                </div>
                <!--Box 3-->
                <div class="relative p-10 rounded-xl h-64 bg-red-600 shadow-2xl md:col-span-1 transition duration-300 ease-out hover:scale-105">
                    <div class="flex z-10 space-x-4">
                        <h1 class="text-2xl">Ping Latency (Milliseconds)</h1>
                    </div>
                    <p class="mt-6 text-xl">
                        Max: <?php echo $maxValues[2]; ?>
                    </p>
                    <p class="text-xl">
                        Min: <?php echo $minValues[2]; ?>
                    </p>
                    <p class="absolute bottom-0 right-0 md:translate-y-4 md:translate-x-4 text-black text-6xl bg-gray-100 rounded-xl">
                        <?php echo $averages[2]; ?>
                    </p>
                </div>
                <!--Box 4-->
                <div class="relative p-10 rounded-xl h-64 bg-black shadow-2xl md:col-span-2 transition duration-300 ease-out hover:scale-105">
                    <div class="flex z-10 space-x-4">
                        <h1 class="text-2xl">Top Server Names</h1>
                    </div>
                    <p class="mt-6 text-xl">
                        <?php  echo $serverName[1]['server_name']; ?>
                    </p>
                    <p class="text-xl">
                        <?php  echo $serverName[2]['server_name']; ?>
                    </p>
                    <p class="text-xl">
                        <?php  echo $serverName[3]['server_name']; ?>
                    </p>
                    <p class="absolute bottom-0 right-0 md:translate-y-4 md:translate-x-4 text-black text-6xl bg-gray-100 rounded-xl">
                        <?php echo trimCharacters($serverName[0]['server_name']); ?>
                    </p>
                </div>
                <!--Box 5-->
                <div class="relative p-10 rounded-xl h-64 bg-cyan-500 shadow-2xl md:col-span-1 transition duration-300 ease-out hover:scale-105">
                    <div class="flex z-10 space-x-4">
                        <h1 class="text-2xl">PacketLoss (%)</h1>
                    </div>
                    <p class="mt-6 text-xl">
                        Max: <?php echo $maxValues[3]; ?>
                    </p>
                    <p class="text-xl">
                        Min: <?php echo $minValues[3]; ?>
                    </p>
                    <p class="absolute bottom-0 right-0 md:translate-y-4 md:translate-x-4 text-black text-6xl bg-gray-100 rounded-xl">
                        <?php echo $averages[3]; ?>
                    </p>
                </div>
            </div>
            <section class="flex flex-col bg-white mt-20 p-2 m-2 space-y-10 shadow-2xl rounded-3xl md:p-15">
                <table class="table-auto">
                    <thead>
                    <tr>
                        <th class="py-2 px-2 border-b">Timestamp</th>
                        <th class="py-2 px-2 border-b hidden sm:table-cell">Download BandWidth (Kb/s)</th>
                        <th class="py-2 px-2 border-b">Download (Mb)</th>
                        <th class="py-2 px-2 border-b hidden sm:table-cell">Upload BandWidth (Kb/s)</th>
                        <th class="py-2 px-2 border-b">Upload (Mb)</th>
                        <th class="py-2 px-2 border-b">More Info</th>
                    </tr>
                    </thead>
                    <tbody class="m-4">
                    <?php
                        foreach ($data as $row) {
                                echo "<tr class='hover:bg-gray-100'>";
                                echo "<td class='py-2 px-2 border-b text-center'>" . htmlspecialchars($row['timestamp']) . "</td>";
                                echo "<td class='py-2 px-2 border-b text-center hidden sm:table-cell'>" . htmlspecialchars($row['download_bandwidth']) . "</td>";
                                echo "<td class='py-2 px-2 border-b text-center'>" . htmlspecialchars($row['download_bytes']) . "</td>";
                                echo "<td class='py-2 px-2 border-b text-center hidden sm:table-cell'>" . htmlspecialchars($row['upload_bandwidth']) . "</td>";
                                echo "<td class='py-2 px-2 border-b text-center'>" . htmlspecialchars($row['upload_bytes']) . "</td>";
                                echo "<td class='py-2 px-2 border-b text-center hover:cursor-pointer hover:bg-red-600 hover:text-white transition duration-300 ease-out hover:ease-in'><a href='/data/show?id=" . htmlspecialchars($row['id']) . "'>Load more</a></td>";
                                echo "</tr>";
                            }
                    ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>