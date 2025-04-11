<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .dropdown-menu {
      display: none;
    }

    .dropdown:focus-within .dropdown-menu {
      display: block;
    }
  </style>
</head>

<body>
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-1/5 bg-blue-950 text-white h-screen p-4 fixed">
      <h1 class="text-4xl mb-6 mt-2 font-medium font-russo">PhoneSwap</h1>
      <ul>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="dashboard.html">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="swapphones.html">
            <i class="fa-solid fa-arrows-rotate mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="usermanagement.html">
            <i class="fa-solid fa-user-group mr-3"></i>
            User Management
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-gray-200 z-10 px-6 py-3 flex justify-between items-center">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Dashboard</h2>
        </div>

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative inline-block text-left">

              <!-- Avatarbar -->
              <div class="relative dropdown">
                <button
                  class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
                  <i class="fa-regular fa-user fa-xl"></i>
                  <div class="flex flex-col items-start">
                    <h1 class="font-medium"><?= htmlspecialchars($userName) ?></h1>
                    <h1 class="text-sm"><?= htmlspecialchars($userRole) ?></h1>
                  </div>
                  <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
                </button>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
                  <a href="../accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account
                    Settings</a>
                  <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                    Logout
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <h3 class="text-xl font-semibold mb-4">Overview</h3>
        <div class="flex laptop:flex-row phone:flex-col gap-4 mb-6">
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalPhones) ?></h4>
            <p class="text-base font-medium">Total Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalActivePhones) ?></h4>
            <p class="text-base font-medium">Active Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalInactivePhones) ?></h4>
            <p class="text-base font-medium">Inactive Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars('0') ?></h4>
            <p class="text-base font-medium">Swap Phones</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalMissingPhones) ?></h4>
            <p class="text-base font-medium">Missing Phones</p>
          </div>
        </div>

        <!-- navig section, filter, search and export button -->
        <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
          <div class="flex flex-row gap-5 border-b border-black">
            <a href="dashboard.php" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Assign
              Phones</a>
            <a href="missingphones.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Missing Phones</a>
          </div>
          <div class="flex flex-row gap-4">
            <!-- Filter and Search -->
            <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
              <div class="flex justify-start">
                <form method="" class="flex flex-row items-center">
                  <select name="filter" id="filterSelect"
                    class="px-4 py-2 h-10 w-36 text-sm border border-gray-700 rounded-l-lg outline-none">
                    <option value="">Select Filter</option>
                    <option value="">Device Model</option>
                    <option value="">Serial Number</option>
                    <option value="">Status</option>
                    <option value="">Assigned</option>
                    <option value="">Report</option>
                  </select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex flex-row ml-auto gap-2">
                <button onclick="openAssignModal()"
                  class="flex items-center gap-2 border border-white bg-amber-400 hover:bg-amber-600 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                  <i class="fa-solid fa-right-to-bracket"></i>
                  <span>Assign</span>
                </button>

                <a href="">
                  <button
                    class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fa-solid fa-filter"></i></i><span>Export</span>
                  </button>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Main table -->
        <div class="rounded-lg shadow-md mt-3">
          <div class="w-full overflow-x-auto h-full rounded-lg">
            <table class="w-full bg-white">
              <thead class="bg-gray-300">
                <tr class="text-left text-sm">
                  <th class="py-3 px-4 border-b">
                    <input type="checkbox" onclick="toggleSelectAll(this)" />
                  </th>
                  <th class="py-3 px-4 border-b">Device Model</th>
                  <th class="py-3 px-4 border-b">Serial Number</th>
                  <th class="py-3 px-4 border-b">Status</th>
                  <th class="py-3 px-4 border-b">Team Member</th>
                  <th class="py-3 px-4 border-b">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($phones as $phone): ?>
                  <tr class="border-b text-left">
                    <!-- Checkbox -->
                    <td class="py-2 px-4 whitespace-nowrap">
                      <input type="checkbox" name="phoneCheckbox" value="<?php echo $phone['serial_number']; ?>"
                        data-model="<?php echo htmlspecialchars($phone['model']); ?>" />
                    </td>

                    <!-- Phone Model -->
                    <td class="py-2 px-4 flex items-center space-x-2">
                      <?php echo htmlspecialchars($phone['model']); ?>
                    </td>

                    <!-- Serial Number -->
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php echo htmlspecialchars($phone['serial_number']); ?>
                    </td>

                    <!-- Status -->
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php if ($phone['status'] === 'Active'): ?>
                        <span
                          class="text-green-800 bg-green-100 border border-green-800 rounded-full py-2 px-6 font-medium shadow-lg">Active</span>
                      <?php elseif ($phone['status'] === 'Inactive'): ?>
                        <span
                          class="text-red-800 bg-red-50 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">Inactive</span>
                      <?php elseif ($phone['status'] === 'Missing'): ?>
                        <span
                          class="text-red-800 bg-red-100 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">Missing</span>
                      <?php else: ?>
                        <span
                          class="text-gray-800 bg-gray-100 border border-gray-800 rounded-full py-2 px-6 font-medium shadow-lg">
                          <?php echo htmlspecialchars($phone['status']); ?>
                        </span>
                      <?php endif; ?>
                    </td>

                    <!-- Assignment Status -->
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php
                      // Check if this phone is assigned to any Team Member
                      $assignedUser = $db->users->findOne([
                        "assigned_phone" => $phone['serial_number'],  // Phone must be assigned to this TM
                        "userType" => "TM",  // The user must be a Team Member (TM)
                        "hfId" => ['$in' => $teamMembers]  // The TM's hfId must be in the TL's team_members array
                      ]);

                      if ($assignedUser) {
                        // Display the Team Member's hfId and Full Name (first_name + last_name)
                        $fullName = htmlspecialchars($assignedUser['first_name'] . ' ' . $assignedUser['last_name']);
                        echo '[' . htmlspecialchars($assignedUser['hfId']) . '] ' . $fullName;
                      } else {
                        // If no Team Member is assigned, show "Unassigned"
                        echo "Unassigned";
                      }
                      ?>
                    </td>
                    <!-- Action Buttons -->
                    <td class="py-2 px-4 whitespace-nowrap space-x-2">
                      <div class="flex flex-row gap-2">
                        <button onclick="openMissingModal('<?php echo $phone['serial_number']; ?>')"
                          class="flex flex-row gap-2 items-center border font-semibold border-white bg-red-700 hover:bg-red-900 text-white px-6 py-1.5 rounded-full shadow-lg">
                          Missing
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>


            </table>
          </div>
        </div>


        <!-- Modal for Assigning Phones -->
        <div id="myModal"
          class="fixed inset-0 flex justify-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
          <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
            <div class="flex flex-col gap-4">
              <h2 class="text-2xl font-russo mb-2">Assign Team Leader</h2>

              <!-- 📦 Selected Phones Container -->
              <div id="selectedPhonesContainer" class="flex flex-col gap-3 max-h-52 overflow-y-auto">
                <!-- dynamically inserted phone cards -->
              </div>

              <!-- 👤 Team Leader Select -->
              <div class="flex flex-col gap-2 w-full mt-4">
                <label for="selectUser" class="text-sm font-medium">Team Leader</label>
                <select name="selectUser" id="selectUser"
                  class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none">
                  <option value="">Select Team Leader</option>
                  <!-- options will be inserted dynamically here -->
                </select>
              </div>

              <div class="flex justify-end gap-2 mt-6">
                <button id="closeModalBtn1"
                  class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                  Cancel
                </button>
                <button onclick="assignPhonesToUser()"
                  class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-black border border-black rounded-lg">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Pagination -->
      <div class="flex justify-end space-x-2 px-14 mb-4">
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          <i class="fa-solid fa-angle-left"></i>
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          1
        </button>
        <button class="border border-gray-300 rounded-lg px-4 py-2 bg-amber-400 text-white font-medium">
          2
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          3
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          4
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          <i class="fa-solid fa-angle-right"></i>
        </button>
      </div>
    </div>
  </div>

</body>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- missing modal -->
<script>
  function openMissingModal(serialNumber) {
    Swal.fire({
      title: 'Mark as Missing?',
      text: `Are you sure you want to mark phone ${serialNumber} as missing?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, mark as missing'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('../phone_management/mark_missing.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ serial_number: serialNumber })
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                icon: 'success',
                title: 'Marked as Missing!',
                text: data.message,
                confirmButtonColor: '#3085d6'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: data.error,
                confirmButtonColor: '#d33'
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire({
              icon: 'error',
              title: 'Oops!',
              text: 'Something went wrong.',
              confirmButtonColor: '#d33'
            });
          });
      }
    });
  }
</script>


<!-- open model -->
<script>
  let allowOutsideClickClose = false;

  function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('input[name="phoneCheckbox"]');
    checkboxes.forEach(checkbox => {
      checkbox.checked = source.checked;
    });
  }

  function openAssignModal() {
    const selected = document.querySelectorAll('input[name="phoneCheckbox"]:checked');
    const container = document.getElementById("selectedPhonesContainer");
    const select = document.getElementById("selectUser");

    console.log("Total selected checkboxes:", selected.length);

    container.innerHTML = "";
    select.innerHTML = '<option value="">Select Team Leader</option>'; // reset dropdown

    if (selected.length === 0) {
      Swal.fire("No Phones Selected", "Please select at least one phone to assign.", "warning");
      return;
    }

    fetch("../controls/fetch_team_Members.php")
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          data.data.forEach(tm => {
            const opt = document.createElement("option");
            opt.value = tm.hfId;
            opt.textContent = `[${tm.hfId}] ${tm.first_name} ${tm.last_name}`;
            select.appendChild(opt);
          });

          // Add "Unassign" option
          const unassignOpt = document.createElement("option");
          unassignOpt.value = "Unassigned";
          unassignOpt.textContent = "Unassign from Team Member";
          select.appendChild(unassignOpt);
        } else {
          console.error("Failed to fetch team members:", data.message); // Log the error message
        }
      })
      .catch(err => {
        console.error("Error fetching team members:", err);
      });



    // Fill phone cards in modal
    selected.forEach(checkbox => {
      const serial = checkbox.value;
      const model = checkbox.getAttribute("data-model");

      console.log("Selected Phone -> Serial:", serial, "Model:", model);

      const phoneCard = document.createElement("div");
      phoneCard.className = "flex flex-col justify-between items-start bg-gray-300 gap-2 pl-4 py-2 rounded-md";
      phoneCard.innerHTML = `
      <p class="pl-2"><strong>Serial:</strong> ${serial}</p>
      <p class="pl-2"><strong>Model:</strong> ${model}</p>
    `;

      container.appendChild(phoneCard);
    });

    const modal = document.getElementById("myModal");
    modal.classList.remove("hidden");

    setTimeout(() => {
      allowOutsideClickClose = true;
    }, 100);
  }

  document.getElementById("closeModalBtn1").addEventListener("click", function () {
    document.getElementById("myModal").classList.add("hidden");
    allowOutsideClickClose = false;
  });

  window.addEventListener("click", function (e) {
    const modal = document.getElementById("myModal");
    const modalContent = modal.querySelector(".bg-white");

    if (
      allowOutsideClickClose &&
      !modal.classList.contains("hidden") &&
      !modalContent.contains(e.target)
    ) {
      modal.classList.add("hidden");
      allowOutsideClickClose = false;
    }
  });

  function assignPhonesToUser() {
    const selectedTL = document.getElementById("selectUser").value;
    const selectedPhones = document.querySelectorAll('input[name="phoneCheckbox"]:checked');

    if (selectedTL === "") {
      Swal.fire("No Team Member Selected", "Please select a Team Member.", "warning");
      return;
    }

    if (selectedPhones.length === 0) {
      Swal.fire("No Phones Selected", "Please select at least one phone.", "warning");
      return;
    }

    let completed = 0;
    let errors = [];

    selectedPhones.forEach((checkbox, index) => {
      const serial = checkbox.value;

      // 🟡 If unassigning, we need to find the TM who owns this phone
      if (selectedTL === "unassigned") {
        // Make a request to fetch all team members and their assigned phones
        fetch("../controls/fetch_team_members.php")
          .then(res => res.json())
          .then(tmData => {
            if (!tmData.success) {
              errors.push(`Serial ${serial}: Failed to fetch team members.`);
              throw new Error(tmData.message);
            }

            // 🔍 Find who has this phone assigned
            const teamMembers = tmData.data;
            const owner = teamMembers.find(tm =>
              tm.assigned_phone && tm.assigned_phone.includes(serial)
            );

            if (!owner) {
              errors.push(`Serial ${serial}: No TM found with this phone.`);
              return;
            }

            // Proceed to unassign it
            return fetch("../controls/assign_phone.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify({
                serial_number: "unassigned",
                TM: owner.hfId
              })
            });
          })
          .then(res => res?.json())
          .then(result => {
            if (result?.success) {
              console.log(`✅ Phone ${serial} unassigned`);
            } else if (result) {
              errors.push(`Serial ${serial}: ${result.error}`);
            }
          })
          .catch(err => {
            errors.push(`Serial ${serial}: ${err.message}`);
          })
          .finally(() => {
            completed++;
            if (completed === selectedPhones.length) handleAssignFinish(errors);
          });

      } else {
        // 🟢 Assign normally
        fetch("../controls/assign_phone.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            serial_number: serial,
            TM: selectedTL
          })
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              console.log(`✅ Phone ${serial} assigned`);
            } else {
              errors.push(`Serial ${serial}: ${data.error}`);
            }
          })
          .catch(err => {
            errors.push(`Serial ${serial}: ${err.message}`);
          })
          .finally(() => {
            completed++;
            if (completed === selectedPhones.length) handleAssignFinish(errors);
          });
      }
    });

    // Helper function to finish up and alert
    function handleAssignFinish(errors) {
      if (errors.length > 0) {
        Swal.fire("Some Assignments Failed", errors.join("<br>"), "error");
      } else {
        Swal.fire("Success", "All phone updates completed!", "success").then(() => {
          location.reload();
        });
      }
    }
  }


</script>



</html>