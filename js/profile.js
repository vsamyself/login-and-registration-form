$(document).ready(function () {
  $("#update").click(function (e) {
    e.preventDefault();

    // Get form data
    var formData = $("#submit").serialize();

    // Send AJAX request
    $.ajax({
      type: "POST",
      url: "http://localhost/php/profile.php",
      data: { update: true, name: "username", number: "newNumber", dob: "newDate" },
      success: function (response) {
        var result = JSON.parse(response);
        if (result.status) {
          $("#msg").html("Profile updated successfully.");
        } else {
          $("#msg").html("Failed to update profile. Please try again.");
        }
      },
      error: function () {
        $("#msg").html("Error updating profile. Please try again.");
      }
    });
  });
});
