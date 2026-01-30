-- Diagnostic Query: Get all appointments with doctor and patient info
SELECT 
    a.id as appointment_id,
    a.appointment_number,
    a.appointment_date,
    a.time_slot,
    a.status,
    a.doctor_id,
    d.doctor_number,
    du.name as doctor_name,
    du.email as doctor_email,
    a.patient_id,
    p.patient_number,
    pu.name as patient_name,
    pu.email as patient_email
FROM appointments a
LEFT JOIN doctors d ON a.doctor_id = d.id
LEFT JOIN users du ON d.user_id = du.id
LEFT JOIN patients p ON a.patient_id = p.id
LEFT JOIN users pu ON p.user_id = pu.id
ORDER BY a.created_at DESC;
