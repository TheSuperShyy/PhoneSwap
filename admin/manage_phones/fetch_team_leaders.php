    <?php
    require __DIR__ . '/../../dbcon/dbcon.php';

    header('Content-Type: application/json');

    try {
        if (!$db) {
            throw new Exception("Database connection failed.");
        }

        $collection = $db->users;

        // Fetch Team Leaders from MongoDB
        $cursor = $collection->find(["userType" => "TL"]); // Correctly defining $cursor
        $teamLeaders = iterator_to_array($cursor); // Using $cursor instead of undefined variable

        $result = [];

        foreach ($teamLeaders as $user) {
            $result[] = [
                "hfId" => $user["hfId"] ?? "UNKNOWN",
                "username" => trim(($user["first_name"] ?? "") . " " . ($user["last_name"] ?? "")), // Safely concatenate names
                "userType" => $user["userType"] ?? "UNKNOWN"
            ];
        }

        echo json_encode(["success" => true, "data" => $result]); // Return valid JSON
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
    ?>