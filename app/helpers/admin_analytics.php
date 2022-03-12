<?php
/* Register All Admin Analytics Here */


/* Stafss */
$query = "SELECT COUNT(*)  FROM users WHERE user_access_level = 'staff' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($staffs);
$stmt->fetch();
$stmt->close();


/* Tenants */
$query = "SELECT COUNT(*)  FROM users WHERE user_access_level = 'tenant' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($tenants);
$stmt->fetch();
$stmt->close();


/* Landlords */
$query = "SELECT COUNT(*)  FROM users WHERE user_access_level = 'landlord' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($landlords);
$stmt->fetch();
$stmt->close();

/* Landlords */
$query = "SELECT COUNT(*)  FROM users WHERE user_access_level = 'caretaker' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($caretakers);
$stmt->fetch();
$stmt->close();

/* Property Categories */
$query = "SELECT COUNT(*)  FROM categories ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($categories);
$stmt->fetch();
$stmt->close();

/* Properties */
$query = "SELECT COUNT(*)  FROM properties ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties);
$stmt->fetch();
$stmt->close();

/* Leased */
$query = "SELECT COUNT(*)  FROM properties WHERE property_status = 'Leased' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_leased);
$stmt->fetch();
$stmt->close();

/* Vacant */
$query = "SELECT COUNT(*)  FROM properties WHERE property_status = 'Vacant' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_vacant);
$stmt->fetch();
$stmt->close();
