  <?php
  require __DIR__ . '/../dbcon/dbcon.php'; // Ensure the correct path

  //dashboard queries
  $totalActivePhones = $db->phones->countDocuments(['status' => 'Active']);
  $totalInactivePhones = $db->phones->countDocuments(['status' => 'Inactive']);
  $totalMissingPhones = $db->phones->countDocuments(['status' => 'Missing']);
  $tableNumber = $db->phones->countDocuments(['assignedTable']);
  $serial = $db->phones->countDocuments(['serial_number']);
  // Fetch all phones
  $phones = $phonesCollection->find([]);

  // Count total phones in the database
  $totalPhones = $db->phones->countDocuments();

  // Fetch all users with userType = 'TL'
  $teamLeadersCursor = $usersCollection->find(['userType' => 'TL']);
  $teamLeaders = [];
  foreach ($teamLeadersCursor as $tl) {
    $teamLeaders[] = $tl['first_name']; // Store TL usernames in an array
  }

  // Fetch all team members hfId
  $teamMembers = [];
  $teamMembersCursor = $usersCollection->find(['userType' => 'TM']);
  foreach ($teamMembersCursor as $tm) {
    $teamMembers[] = $tm['hfId']; // Store TL usernames in an array
  }

  // Fetch all team members' full names
  $teamMembers = [];
  $teamMembersCursor = $usersCollection->find(['userType' => 'TM']);
  foreach ($teamMembersCursor as $tm) {
    $fullName = $tm['first_name'] . ' ' . $tm['last_name']; // Concatenate first and last name
    $teamMembers[] = $fullName;
  }

  // fetch all phones serial number and model
  $phoneData = [];
  $phonesCursor = $phonesCollection->find([], ['projection' => ['serial_number' => 1, 'model' => 1]]);
  foreach ($phonesCursor as $phone) {
      $phoneData[] = [
          'serial_number' => $phone['serial_number'],
          'model' => $phone['model']
      ];
  }

  //find all user
  $usersCollection = $db->users;
  $users = $usersCollection->find(['userType' => 'TM']);



  ?>
