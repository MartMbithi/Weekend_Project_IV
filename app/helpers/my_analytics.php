<?php
/* Register All Tenant Analytics Here */

$user_id  = $_SESSION['user_id'];


/* Vacant */
$query = "SELECT COUNT(*)  FROM houses WHERE house_status = 'Vacant' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($properties_vacant);
$stmt->fetch();
$stmt->close();


/* Rent Collections */
$query = "SELECT SUM(payment_amount)  FROM payments p  INNER JOIN house_rentals hr 
ON hr.rental_id = p.payment_rental_id INNER JOIN houses h ON h.house_id = hr.rental_house_id
WHERE hr.rental_tenant_id  = '$user_id'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($payments);
$stmt->fetch();
$stmt->close();

/* Pending Payments */
$ret = "SELECT * FROM house_rentals hr
INNER JOIN  houses h on h.house_id = hr.rental_house_id
INNER JOIN categories c ON c.category_id  = h.house_category_id
INNER JOIN users u ON u.user_id = hr.rental_tenant_id 
WHERE hr.rental_eviction_status = '0' AND hr.rental_tenant_id = '$user_id' AND hr.rental_payment_status = 'Pending'";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($leases = $res->fetch_object()) {
    $payable_rent = $leases->rental_duration * $leases->house_cost;
}
