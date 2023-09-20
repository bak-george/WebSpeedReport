<?php
require base_path('views/partials/head.php') ?>
<body class="bg-gray-100 font-mono">
    <main>
        <h1 class="text-6xl text-center">Web Speed Report</h1>
    </main>
    <section class="container mx-auto max-w-8xl md:p-10">
        <a href="/">
            <div class="rounded-full bg-gray-500 inline-block px-4 py-2 shadow-lg hover:cursor-pointer hover:bg-gray-100 transition duration-300 ease-out hover:ease-in">Back to Dashboard</div>
        </a>
        <div class="flex flex-col mx-auto bg-white mt-4 p-2 m-2 space-y-10 shadow-2xl rounded-3xl md:p-15">
            <table class="bg-white border-gray-200">
                <thead>
                <tr>
                    <th class="py-2 px-2 border-b">Title</th>
                    <th class="py-2 px-2 border-b">Data</th>
                </tr>
                </thead>
                <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2">Timestamp</td>
                    <td class="text-center py-2"><?php echo htmlspecialchars($data['timestamp']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-2">Ping Jitter (Milliseconds)</td>
                    <td class="text-center py-2 px-2"><?php echo htmlspecialchars($data['ping_jitter']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-2">Ping Latency (Milliseconds)</td>
                    <td class="text-center py-2 px-2"><?php echo htmlspecialchars($data['ping_latency']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-2">Ping Low (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['ping_low']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Ping High (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['ping_high']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Bandwidth (Kb/s)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_bandwidth']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Bytes (Mb)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_bytes']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Elapsed (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_elapsed']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Latency iqm (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_latency_iqm']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Latency High (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_latency_high']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Latency Low (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_latency_low']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Download Latency Jitter (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['download_latency_jitter']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Bandwidth (Kb/s)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_bandwidth']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Bytes (Mb)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_bytes']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Elapsed (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_elapsed']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Latency iqm (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_latency_iqm']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Latency High (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_latency_high']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Latency Low (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_latency_low']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Upload Latency Jitter (Milliseconds)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['upload_latency_jitter']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Packet Loss (%)</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['packetLoss']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">ISP</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['isp']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Interface Internal IP</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['interface_internalIp']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Interface Name</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['interface_name']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Interface Mac Addr</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['interface_macAddr']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Interface Is VPN</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['interface_isVpn']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Interface External IP</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['interface_externalIp']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Id</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_id']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Host</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_host']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Port</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_port']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Name</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_name']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Location</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_location']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Country</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_country']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Server Ip</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['server_ip']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Result Id</td>
                    <td class="text-center py-2 px-4"><?php echo htmlspecialchars($data['result_id']) ?></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="text-center py-2 px-4">Result Url</td>
                    <td class="text-center py-2 px-4 hover:cursor-pointer hover:bg-red-600 hover:text-white hover:cursor-pointer transition duration-300 ease-out hover:ease-in">
                        <a href="<?php echo htmlspecialchars($data['result_url']) ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo htmlspecialchars($data['result_url']) ?>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>


