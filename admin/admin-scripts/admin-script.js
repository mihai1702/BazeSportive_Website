document.addEventListener('DOMContentLoaded', () => {


  let reservationsTable = document.getElementById('reservations-table');
  let accountsTable = document.getElementById('accounts-table');

  let btnReservations = document.getElementById('btn-reservations');
  let btnAccounts = document.getElementById('btn-accounts');

  btnReservations.onclick = function() {
    reservationsTable.classList.add('active');
    accountsTable.classList.remove('active');
    btnReservations.classList.add('active');
    btnAccounts.classList.remove('active');
  };
  btnAccounts.onclick = function() {
    accountsTable.classList.add('active');
    reservationsTable.classList.remove('active');
    btnAccounts.classList.add('active');
    btnReservations.classList.remove('active');
  }

  // Fetch and display reservations
  $(document).ready(function() {
        $.ajax({
          url: '../admin/fetch-reservations.php',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            let tbody = $('#reservations-table tbody');
            data.forEach(function(reservation) {
              let row =   `<tr>
                            <td>${reservation.reservation_id}</td>
                            <td>${reservation.date}</td>
                            <td>${reservation.start_time}</td>
                            <td>${reservation.end_time}</td>
                            <td>${reservation.client_name}</td>
                            <td>${reservation.nr_participants}</td>
                          </tr>`;
              tbody.append(row);
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr);
            console.error(status);
          console.error('Error fetching reservations:', error);
        }
        }); 
      })
  });


  // Fetch and display accounts 
  $(document).ready(function() {
      $.ajax({
        url: '../admin/fetch-accounts.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          let tbody = $('#accounts-table tbody');
          data.forEach(function(account) {
            let row = `<tr>
                          <td>${account.account_id}</td>
                          <td>${account.full_name}</td>
                          <td>${account.username}</td>
                          <td>${account.email}</td>
                          <td>${account.cod_liga}</td>
                          <td>${account.role}</td>
                          <td><input class="account-checkbox" type="checkbox" data-id="${account.account_id}" ${account.is_active == 1 ? 'checked' : ''}></td>
                       </tr>`;
            tbody.append(row);
          });
        }, 
        error: function(xhr, status, error) {
          console.error(xhr);
          console.error(status);
          console.error('Error fetching accounts:', error);
        }
      })
  });


  $(document).on("change", '.account-checkbox', function() {
    let accountId=$(this).data('id');
    let newStatus=$(this).is(':checked') ? 1 : 0;
    $.ajax({
      url: '../admin/update-account-status.php',
      type: 'POST',
      data: {
        account_id: accountId,
        is_active: newStatus
      },
      success: function(response) {
        console.log('Account status updated successfully');
      },
      error: function(xhr, status, error) {
        console.error('Error updating account status:', error);
      }
    })
  });
