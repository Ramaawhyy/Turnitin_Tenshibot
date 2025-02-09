private function sendWhatsAppNotification($document)
{
    try {
        // Retrieve the API key from the .env file
        $apiKey = env('FONNTE_API_KEY');

        // Prepare other necessary variables
        $nomor_admin = '62882000018016';  // Replace with your admin's WhatsApp number
        $nomor_pengguna = '62' . ltrim($document->nomor_hp, '0');

        $message = "Ada dokumen baru yang diunggah oleh pengguna dengan nomor: $nomor_pengguna.";

        // Prepare the file to send
        $filePath = storage_path('app/' . $document->dokumen);

        // Prepare the POST data
        $postData = [
            'target' => $nomor_admin,
            'message' => $message,
            'countryCode' => '62',
        ];

        if (file_exists($filePath)) {
            $postData['file'] = new \CURLFile($filePath);
        } else {
            Log::error("File tidak ditemukan: " . $filePath);
        }

        // Initialize cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $apiKey  // Using the API key here
            ),
        ));

        // Execute the cURL request
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error("cURL Error: " . $error_msg);
        }

        curl_close($curl);

        // Handle the response
        $responseData = json_decode($response, true);

        if (isset($responseData['status']) && $responseData['status'] == true) {
            Log::info("Pesan WhatsApp berhasil dikirim ke: $nomor_admin");
        } else {
            Log::error("Gagal mengirim pesan WhatsApp ke $nomor_admin. Response: " . $response);
        }
    } catch (\Exception $e) {
        Log::error("Gagal mengirim pesan WhatsApp ke $nomor_admin. Error: " . $e->getMessage());
    }
}