document.getElementById("insertForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    
    // Get form data
    var fullname = document.getElementById("fullname").value;
    var matric_no = document.getElementById("matric_no").value;
    var password = document.getElementById("password").value;
    var session = document.getElementById("session").value;
    var faculty = document.getElementById("faculty").value;
    var dept = document.getElementById("dept").value;
    var phone = document.getElementById("phone").value;
    
    // Send data to insert.php using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "insert.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Response received, do something with it (e.g., display a success message)
            alert(xhr.responseText);
            document.getElementById("insertForm").reset();
        }
    };
    xhr.send("fullname=" + fullname + "&matric_no=" + matric_no + "&password=" + password + "&session=" + session + "&faculty=" + faculty + "&dept=" + dept + "&phone=" + phone);
});
