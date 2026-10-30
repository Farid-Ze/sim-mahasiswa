<?php
/**
 * English dictionary.
 * Associative array: key => text shown on the interface.
 */
return [
    "html_lang"           => "en",
    "app_name"            => "SIMADA",
    "app_full"            => "Student Data Management Information System",
    "bahasa"              => "Language",

    // Navigation
    "nav_data"            => "Student Data",
    "nav_tambah"          => "Add Data",
    "nav_logout"          => "Log out",
    "welcome"             => "Hi, %s",

    // Login
    "login_title"         => "Sign in to the System",
    "login_sub"           => "Use the admin account to manage student data.",
    "username"            => "Username",
    "password"            => "Password",
    "btn_login"           => "Sign in",
    "login_hint"          => "Demo account: admin / admin123",
    "err_login_kosong"    => "Username and password are required.",
    "err_login_salah"     => "Incorrect username or password.",
    "flash_login_dulu"    => "Please sign in first to access this page.",
    "flash_login_ok"      => "Welcome, %s!",
    "flash_logout"        => "You have been signed out.",

    // Dashboard / data list
    "dash_title"          => "Student Data",
    "dash_sub"            => "Manage all student records stored in the database.",
    "stat_total"          => "Total Students",
    "stat_l"              => "Male",
    "stat_p"              => "Female",
    "stat_jurusan"        => "Study Programs",
    "search_placeholder"  => "Search student ID, name, or study program…",
    "btn_cari"            => "Search",
    "btn_reset"           => "Reset",
    "hasil_cari"          => "Search results for \"%s\": %d record(s) found.",
    "th_no"               => "No",
    "th_nim"              => "Student ID",
    "th_nama"             => "Name",
    "th_email"            => "Email",
    "th_jk"               => "M/F",
    "th_jurusan"          => "Study Program",
    "th_angkatan"         => "Intake Year",
    "th_aksi"             => "Actions",
    "btn_edit"            => "Edit",
    "btn_hapus"           => "Delete",
    "confirm_hapus"       => "Are you sure you want to delete this student record?",
    "data_kosong"         => "No student data yet.",

    // Add / edit form
    "form_tambah_title"   => "Add Student Data",
    "form_tambah_sub"     => "Fill in the form below to save a new student record.",
    "form_edit_title"     => "Edit Student Data",
    "form_edit_sub"       => "Update the student record identified by its unique ID.",
    "lbl_nim"             => "Student ID (NIM)",
    "lbl_nama"            => "Full Name",
    "lbl_email"           => "Email",
    "lbl_jk"              => "Gender",
    "lbl_jurusan"         => "Study Program",
    "lbl_angkatan"        => "Intake Year",
    "lbl_alamat"          => "Address",
    "jk_l"                => "Male",
    "jk_p"                => "Female",
    "pilih_jurusan"       => "-- Choose Study Program --",
    "opsional"            => "optional",
    "hint_nim"            => "8–10 digits",
    "btn_simpan"          => "Save",
    "btn_update"          => "Save Changes",
    "btn_batal"           => "Cancel",

    // Validation
    "err_title"           => "The data could not be saved. Please check the following:",
    "err_nim_kosong"      => "Student ID is required.",
    "err_nim_format"      => "Student ID must be 8–10 digits.",
    "err_nim_duplikat"    => "Student ID is already registered to another record.",
    "err_nama_kosong"     => "Full name is required.",
    "err_nama_format"     => "Name may only contain letters, spaces, periods, or apostrophes (3–100 characters).",
    "err_email_kosong"    => "Email is required.",
    "err_email_format"    => "Invalid email format.",
    "err_jk_kosong"       => "Please choose a gender.",
    "err_jurusan_kosong"  => "Please choose a study program.",
    "err_jurusan_invalid" => "Unknown study program selected.",
    "err_angkatan_kosong" => "Intake year is required.",
    "err_angkatan_format" => "Intake year must be between 2000 and %d.",
    "err_alamat_panjang"  => "Address may be at most 255 characters.",
    "err_csrf"            => "Invalid form session. Please reload the page and try again.",

    // Result messages
    "flash_tambah_ok"     => "Student %s was added successfully.",
    "flash_edit_ok"       => "Student %s was updated successfully.",
    "flash_hapus_ok"      => "Student %s was deleted successfully.",
    "flash_tidak_ada"     => "Student record not found.",
    "flash_db_error"      => "A database error occurred: %s",

    "footer"              => "Assignment 2, Internet Technology Application · Dziban Arkan (77961325) · IF-3 · Informatics Engineering UNIKOM",
];
