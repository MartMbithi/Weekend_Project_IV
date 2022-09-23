<?php
/* Register All Landlord Analytics Here */

$user_id  = $_SESSION['user_id'];

/* Properties */
$query = "SELECT COUNT(*)  FROM houses WHERE house_landlord_id = '$user_id' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties);
$stmt->fetch();
$stmt->close();

/* Leased */
$query = "SELECT COUNT(*)  FROM houses WHERE house_status = 'Leased' AND house_landlord_id = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_leased);
$stmt->fetch();
$stmt->close();

/* Vacant */
$query = "SELECT COUNT(*)  FROM houses WHERE house_status = 'Vacant' AND house_landlord_id = '$user_id' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_vacant);
$stmt->fetch();
$stmt->close();


/* Rent Collections */
$query = "SELECT SUM(payment_amount)  FROM payments p  INNER JOIN house_rentals hr 
ON hr.rental_id = p.payment_rental_id INNER JOIN houses h ON h.house_id = hr.rental_house_id
WHERE h.house_landlord_id  = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($payments);
$stmt->fetch();
$stmt->close();
