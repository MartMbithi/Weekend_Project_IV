<?php
/* Register All Landlord Analytics Here */

$user_id  = $_SESSION['user_id'];

/* Properties */
$query = "SELECT COUNT(*)  FROM properties WHERE property_landlord_id = '$user_id' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties);
$stmt->fetch();
$stmt->close();

/* Leased */
$query = "SELECT COUNT(*)  FROM properties WHERE property_status = 'Leased' AND property_landlord_id = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_leased);
$stmt->fetch();
$stmt->close();

/* Vacant */
$query = "SELECT COUNT(*)  FROM properties WHERE property_status = 'Vacant' AND property_landlord_id = '$user_id' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_vacant);
$stmt->fetch();
$stmt->close();


/* Rent Collections */
$query = "SELECT SUM(payment_amount)  FROM payments p  INNER JOIN property_leases pl 
ON pl.lease_id = p.payment_lease_id INNER JOIN properties pr ON pr.property_id = pl.lease_property_id
WHERE pr.property_landlord_id  = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($payments);
$stmt->fetch();
$stmt->close();
