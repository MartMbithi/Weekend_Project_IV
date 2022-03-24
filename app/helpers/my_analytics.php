<?php
/* Register All Tenant Analytics Here */

$user_id  = $_SESSION['user_id'];


/* Vacant */
$query = "SELECT COUNT(*)  FROM properties WHERE property_status = 'Vacant' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_vacant);
$stmt->fetch();
$stmt->close();


/* Rent Collections */
$query = "SELECT SUM(payment_amount)  FROM payments p  INNER JOIN property_leases pl 
ON pl.lease_id = p.payment_lease_id INNER JOIN properties pr ON pr.property_id = pl.lease_property_id
WHERE pl.lease_tenant_id  = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($payments);
$stmt->fetch();
$stmt->close();

/* Pending Payments */
$ret = "SELECT * FROM property_leases pl
INNER JOIN  properties p on p.property_id = pl.lease_property_id
INNER JOIN categories c ON c.category_id  = p.property_category_id
INNER JOIN users u ON u.user_id = pl.lease_tenant_id 
WHERE pl.lease_eviction_status = '0' AND pl.lease_tenant_id = '$user_id' AND pl.lease_payment_status = 'Pending'";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($leases = $res->fetch_object()) {
    $payable_rent = $leases->lease_duration * $leases->property_cost;
}
