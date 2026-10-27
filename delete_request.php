<?php
include('connect.php');

if (isset($_GET['matric_no'])) {
    $matric_no = $_GET['matric_no'];

    $sql = "DELETE FROM clearance_requests WHERE matric_no = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $matric_no);
        if ($stmt->execute()) {
            header("Location: clerance_requestdetail.php?msg=Record deleted successfully");
        } else {
            echo "Error: Could not execute $sql. " . $conn->error;
        }
    } else {
        echo "Error: Could not prepare query $sql. " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: Invalid request.";
}
?>
