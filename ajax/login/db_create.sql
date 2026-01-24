-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2026 at 09:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testimonytbl1`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_calendar`
--

CREATE TABLE `academic_calendar` (
  `term` varchar(10) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `closing_date` date NOT NULL,
  `id` int(11) NOT NULL,
  `academic_year` varchar(10) DEFAULT NULL
);

--
-- Dumping data for table `academic_calendar`
--

INSERT INTO `academic_calendar` (`term`, `start_time`, `end_time`, `closing_date`, `id`, `academic_year`) VALUES
('TERM_1', '2025-01-01', '2025-04-30', '2025-04-30', 1, '2022'),
('TERM_2', '2025-05-01', '2025-08-31', '2025-08-31', 2, '2022'),
('TERM_3', '2025-09-01', '2025-12-31', '2025-12-31', 3, '2022');

-- --------------------------------------------------------

--
-- Table structure for table `advance_pay`
--

CREATE TABLE `advance_pay` (
  `month_effect` varchar(200) NOT NULL,
  `amount` int(11) NOT NULL,
  `installments` int(11) NOT NULL,
  `date_taken` varchar(200) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `balance_left` int(11) NOT NULL,
  `payment_breakdown` longtext DEFAULT NULL,
  `advance_id` int(11) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `apply_leave`
--

CREATE TABLE `apply_leave` (
  `leave_category` int(11) DEFAULT NULL,
  `employee_id` varchar(200) DEFAULT NULL,
  `days_duration` int(11) DEFAULT NULL,
  `from` varchar(200) DEFAULT NULL,
  `to` varchar(200) DEFAULT NULL,
  `date_applied` varchar(200) DEFAULT NULL,
  `leave_description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 pending 1 accepted 2 declined',
  `id` int(11) NOT NULL
);

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `name` varchar(500) DEFAULT NULL,
  `period` varchar(500) DEFAULT NULL,
  `questions` longtext DEFAULT NULL,
  `answers` longtext DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `date_created` varchar(50) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `subject_id` varchar(200) DEFAULT NULL,
  `academic_yr` varchar(200) DEFAULT NULL,
  `id` int(11) NOT NULL
);


--
-- Table structure for table `attendancetable`
--

CREATE TABLE `attendancetable` (
  `id` int(11) NOT NULL,
  `admission_no` varchar(100) DEFAULT NULL,
  `class` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `signedby` varchar(40) NOT NULL
);

--
-- Table structure for table `behaviour_comment`
--

CREATE TABLE `behaviour_comment` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `behaviour_objective_id` int(11) DEFAULT NULL,
  `rubric_score` varchar(200) DEFAULT NULL
);

--
-- Table structure for table `behaviour_goal`
--

CREATE TABLE `behaviour_goal` (
  `behaviour_goal_id` int(11) NOT NULL,
  `goal_name` varchar(255) DEFAULT NULL,
  `grades` varchar(5000) DEFAULT NULL,
  `item_status` int(1) NOT NULL DEFAULT 1
);

--
-- Table structure for table `behaviour_objective`
--

CREATE TABLE `behaviour_objective` (
  `behaviour_objective_id` int(11) NOT NULL,
  `objective_name` varchar(500) DEFAULT NULL,
  `behaviour_goal_id` int(11) DEFAULT NULL
);

--
-- Table structure for table `behaviour_scores`
--

CREATE TABLE `behaviour_scores` (
  `behaviour_scores_id` int(11) NOT NULL,
  `student_adm` varchar(200) DEFAULT NULL,
  `score` varchar(200) DEFAULT NULL,
  `grade` varchar(200) DEFAULT NULL,
  `grading_method` varchar(200) DEFAULT NULL,
  `behaviour_objective_id` int(11) DEFAULT NULL,
  `date_recorded` varchar(200) DEFAULT NULL,
  `objective_comment` varchar(11) DEFAULT NULL
);

--
-- Table structure for table `boarding_list`
--

CREATE TABLE `boarding_list` (
  `id` int(11) NOT NULL,
  `student_id` varchar(200) NOT NULL,
  `dorm_id` int(11) NOT NULL,
  `date_of_enrollment` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `activated` int(11) NOT NULL
);

--
-- Table structure for table `book_circulation`
--

CREATE TABLE `book_circulation` (
  `circulation_id` int(11) NOT NULL,
  `book_isbn` mediumtext DEFAULT NULL,
  `book_id` varchar(200) DEFAULT NULL,
  `book_call_number` mediumtext DEFAULT NULL,
  `user_checked_out` mediumtext DEFAULT NULL,
  `user_borrowing` mediumtext DEFAULT NULL,
  `date_checked_out` mediumtext DEFAULT NULL,
  `expected_return_date` mediumtext DEFAULT NULL,
  `checked_out_by` mediumtext DEFAULT NULL,
  `checked_in_by` varchar(200) DEFAULT NULL,
  `fine_per_day` mediumtext DEFAULT NULL,
  `fine_status` mediumtext DEFAULT NULL,
  `return_status` int(11) NOT NULL DEFAULT 0,
  `return_date` varchar(200) DEFAULT NULL,
  `comments` varchar(2000) DEFAULT NULL
);

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `chat_content` varchar(1000) DEFAULT NULL,
  `chat_sender` varchar(1000) DEFAULT NULL,
  `chat_recipient` varchar(1000) DEFAULT NULL,
  `date_sent` varchar(1000) DEFAULT NULL,
  `date_read` varchar(1000) DEFAULT NULL,
  `sender_type` varchar(1000) DEFAULT NULL,
  `recipient_type` varchar(1000) DEFAULT NULL
);

--
-- Table structure for table `class_teacher_tbl`
--

CREATE TABLE `class_teacher_tbl` (
  `class_teacher_id` int(11) NOT NULL,
  `class_assigned` varchar(30) NOT NULL,
  `active` int(11) NOT NULL
);

--
-- Table structure for table `dorm_list`
--

CREATE TABLE `dorm_list` (
  `dorm_id` int(11) NOT NULL,
  `dorm_name` varchar(200) NOT NULL,
  `dorm_capacity` int(11) NOT NULL,
  `dorm_captain` varchar(200) NOT NULL,
  `activated` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
);

--
-- Table structure for table `email_address`
--

CREATE TABLE `email_address` (
  `id` int(11) NOT NULL,
  `sender_from` varchar(500) DEFAULT NULL,
  `recipient_to` varchar(500) DEFAULT NULL,
  `bcc` varchar(500) DEFAULT NULL,
  `date_time` varchar(50) DEFAULT NULL,
  `message_subject` varchar(500) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `cc` varchar(500) DEFAULT NULL,
  `attachments` mediumtext DEFAULT NULL
);

--
-- Table structure for table `exams_tbl`
--

CREATE TABLE `exams_tbl` (
  `exams_id` int(11) NOT NULL,
  `exams_name` varchar(100) NOT NULL,
  `curriculum` varchar(300) NOT NULL,
  `class_sitting` varchar(5000) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `subject_done` varchar(500) NOT NULL,
  `target_mean_score` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `students_sitting` longtext DEFAULT NULL
);

--
-- Table structure for table `exam_record_tbl`
--

CREATE TABLE `exam_record_tbl` (
  `result_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` varchar(200) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_marks` int(11) NOT NULL,
  `exam_grade` varchar(10) NOT NULL,
  `grade_method` varchar(200) NOT NULL DEFAULT '844',
  `filled_by` varchar(100) NOT NULL,
  `class name` varchar(20) DEFAULT NULL
);

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expid` int(11) NOT NULL,
  `exp_name` varchar(100) NOT NULL,
  `exp_category` varchar(300) NOT NULL,
  `unit_name` varchar(30) DEFAULT NULL,
  `exp_quantity` int(11) NOT NULL,
  `exp_unit_cost` int(11) NOT NULL,
  `exp_amount` int(11) NOT NULL DEFAULT 0,
  `expense_date` date NOT NULL,
  `exp_time` varchar(10) NOT NULL,
  `exp_active` int(11) NOT NULL DEFAULT 0
);

--
-- Table structure for table `fees_credit_note`
--

CREATE TABLE `fees_credit_note` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `month` varchar(200) DEFAULT NULL,
  `staff_id` varchar(200) DEFAULT NULL,
  `assigned` varchar(200) DEFAULT '0',
  `date_registered` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `transaction_id` varchar(200) DEFAULT '0'
);

--
-- Table structure for table `fees_structure`
--

CREATE TABLE `fees_structure` (
  `expenses` varchar(100) NOT NULL,
  `display_name` varchar(2000) DEFAULT NULL,
  `TERM_1` int(11) NOT NULL,
  `TERM_2` int(11) NOT NULL,
  `TERM_3` int(11) NOT NULL,
  `classes` mediumtext DEFAULT NULL,
  `ids` int(11) NOT NULL,
  `activated` int(11) NOT NULL DEFAULT 1,
  `roles` varchar(30) NOT NULL,
  `date_changed` varchar(11) DEFAULT NULL,
  `term_1_old` int(11) DEFAULT 0,
  `term_2_old` int(11) DEFAULT 0,
  `term_3_old` int(11) DEFAULT 0
);

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `stud_admin` varchar(200) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `time_of_transaction` varchar(30) NOT NULL,
  `date_of_transaction` varchar(30) NOT NULL,
  `transaction_code` varchar(100) NOT NULL DEFAULT '0',
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_for` longtext NOT NULL,
  `payBy` varchar(100) NOT NULL DEFAULT 'sys',
  `mode_of_pay` varchar(50) NOT NULL,
  `mpesa_mode_of_payment` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `idsd` varchar(10) NOT NULL DEFAULT '0',
  `support_document` longtext DEFAULT NULL
);

--
-- Table structure for table `leave_categories`
--

CREATE TABLE `leave_categories` (
  `leave_title` varchar(300) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `max_days` int(11) DEFAULT NULL,
  `leave_year_starts` varchar(500) DEFAULT NULL,
  `days_are_accrued` varchar(500) DEFAULT NULL,
  `period_accrued` varchar(500) DEFAULT NULL,
  `max_days_carry_forward` int(11) DEFAULT NULL,
  `employment_type` varchar(500) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `id` int(11) NOT NULL
);

--
-- Table structure for table `lesson_plan`
--

CREATE TABLE `lesson_plan` (
  `subject_id` varchar(10) DEFAULT NULL,
  `academic_year` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `longterm_plan_data` longtext DEFAULT NULL,
  `medium_term_plan` longtext DEFAULT NULL,
  `short_term_plan` longtext DEFAULT NULL,
  `id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '1',
  `long_term_status` varchar(200) DEFAULT '0',
  `medium_term_status` int(11) DEFAULT 0,
  `short_term_status` int(11) DEFAULT 0
);

--
-- Table structure for table `library_details`
--

CREATE TABLE `library_details` (
  `book_id` int(11) NOT NULL,
  `book_title` mediumtext DEFAULT NULL,
  `book_author` mediumtext DEFAULT NULL,
  `book_publishers` mediumtext DEFAULT NULL,
  `published_date` mediumtext DEFAULT NULL,
  `thumbnail_location` mediumtext DEFAULT NULL,
  `book_category` mediumtext DEFAULT NULL,
  `isbn_13` mediumtext DEFAULT NULL,
  `isbn_10` mediumtext DEFAULT NULL,
  `date_recorded` mediumtext DEFAULT NULL,
  `physical_dimensions` mediumtext DEFAULT NULL,
  `no_of_revisions` mediumtext DEFAULT NULL,
  `call_no` mediumtext DEFAULT NULL,
  `language` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `shelf_no_location` mediumtext DEFAULT NULL,
  `keywords` mediumtext DEFAULT NULL,
  `edition` mediumtext DEFAULT NULL,
  `no_of_pages` mediumtext DEFAULT NULL,
  `availability_status` int(11) NOT NULL DEFAULT 1 COMMENT '0 - absent\r\n1 - present',
  `library_location` varchar(200) NOT NULL DEFAULT '1',
  `lost_status` int(1) NOT NULL DEFAULT 0,
  `date_lost` varchar(200) DEFAULT NULL,
  `date_reported` varchar(200) DEFAULT NULL,
  `who_lost_it` varchar(200) DEFAULT NULL,
  `who_reported_it` varchar(200) DEFAULT NULL
);

--
-- Table structure for table `library_notifications`
--

CREATE TABLE `library_notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_title` varchar(1000) NOT NULL,
  `notification_content` longtext NOT NULL,
  `notification_action` longtext NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `book_id` varchar(200) NOT NULL COMMENT 'this value will be used to associate a book to the notification  so that if the book was die for checkin the book id will be added here and when the book is checked out this notification will be delete by the system,',
  `notification_type` int(11) NOT NULL DEFAULT 1
);

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `login_time` varchar(10) NOT NULL,
  `active_time` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL
);

--
-- Table structure for table `message_n_alert`
--

CREATE TABLE `message_n_alert` (
  `id` int(11) NOT NULL,
  `owner_id` varchar(200) DEFAULT NULL,
  `message_title` varchar(2000) DEFAULT NULL,
  `message_body` longtext DEFAULT NULL,
  `owner_type` varchar(200) DEFAULT NULL,
  `message_status` int(11) DEFAULT NULL,
  `date_created` varchar(200) DEFAULT NULL,
  `message_edit_status` varchar(200) DEFAULT '0' COMMENT 'This is the message edit status 0 if its a draft then 1 if its public.',
  `message_editor_id` varchar(200) DEFAULT NULL COMMENT 'this is the common id for this message that its going to uniquely identify it as a group. It will be shared among the message recipients',
  `created_by` varchar(200) DEFAULT NULL
);

--
-- Table structure for table `mpesa_transactions`
--

CREATE TABLE `mpesa_transactions` (
  `transaction_id` int(11) NOT NULL,
  `mpesa_id` varchar(200) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `std_adm` varchar(200) DEFAULT NULL,
  `assigned_transaction` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `transaction_time` varchar(200) DEFAULT NULL,
  `short_code` varchar(25) DEFAULT NULL,
  `payment_number` varchar(100) DEFAULT NULL,
  `fullname` varchar(300) DEFAULT NULL,
  `transaction_status` int(11) DEFAULT 0 COMMENT '1 for assigned , 0 for not assigned'
);

--
-- Table structure for table `parent_account_payment`
--

CREATE TABLE `parent_account_payment` (
  `transaction_id` int(12) NOT NULL,
  `amount_paid` decimal(15,2) DEFAULT NULL,
  `date_paid` varchar(200) DEFAULT NULL,
  `payment_code` varchar(200) DEFAULT NULL,
  `account_balance` decimal(15,2) DEFAULT NULL,
  `parent_phone_number` varchar(20) DEFAULT NULL,
  `payment_linked` longtext DEFAULT NULL,
  `paid_by` varchar(200) DEFAULT NULL,
  `mode_of_payment` varchar(200) DEFAULT NULL,
  `mpesa_mode_of_payment` varchar(200) DEFAULT NULL
);

--
-- Table structure for table `payroll_information`
--

CREATE TABLE `payroll_information` (
  `staff_id` int(11) DEFAULT NULL,
  `payroll_id` int(11) NOT NULL,
  `initial_balance` varchar(255) DEFAULT '-1',
  `current_balance` int(11) DEFAULT NULL,
  `current_balance_monNyear` varchar(300) DEFAULT NULL,
  `salary_amount` mediumtext DEFAULT NULL,
  `effect_month` mediumtext DEFAULT NULL,
  `salary_breakdown` longtext DEFAULT NULL
);

--
-- Table structure for table `questionbanks`
--

CREATE TABLE `questionbanks` (
  `id` int(11) NOT NULL,
  `class` varchar(200) DEFAULT NULL,
  `subject_id` varchar(200) DEFAULT NULL,
  `questions` longtext DEFAULT NULL
);

--
-- Table structure for table `salary_payment`
--

CREATE TABLE `salary_payment` (
  `pay_id` int(11) NOT NULL,
  `staff_paid` int(11) DEFAULT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `mode_of_payment` varchar(50) DEFAULT NULL,
  `payment_code` varchar(100) DEFAULT NULL,
  `date_paid` varchar(20) DEFAULT NULL,
  `time_paid` varchar(20) DEFAULT NULL,
  `type_of_payment` varchar(200) DEFAULT 'salary'
);

--
-- Table structure for table `school_vans`
--

CREATE TABLE `school_vans` (
  `van_id` int(11) NOT NULL,
  `van_name` varchar(45) DEFAULT NULL,
  `van_reg_no` varchar(45) DEFAULT NULL,
  `model_name` varchar(300) DEFAULT NULL,
  `van_seater_size` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `insurance_expiration` varchar(40) DEFAULT NULL,
  `next_service_date` varchar(200) DEFAULT NULL,
  `driver_name` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1
);

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sett` varchar(200) NOT NULL,
  `valued` mediumtext NOT NULL,
  `id` int(11) NOT NULL
);

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sett`, `valued`, `id`) VALUES
('admissionessentials', '', 1),
('class', 'Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9', 2),
('lastadmgen', '1', 5),
('user_roles', '[]', 6),
('clubs/sports_house', '[]', 7),
('email_setup', '{\"sender_name\":\"Ladybird Softech Co.\",\"email_host_addr\":\"mail.privateemail.com\",\"email_username\":\"mail@ladybirdsmis.com\",\"email_password\":\"H1l@ryNgige\",\"tester_mail\":\"hilaryme45@gmail.com\"}', 8),
('working_days', 'Tue,Wed,Thur,Fri,Sat,Mon', 9),
('last_acad_yr', '[{\"TERM_1\":{\"START_DATE\":\"2022-04-25\",\"END_DATE\":\"2022-07-11\"},\"TERM_2\":{\"START_DATE\":\"2022-07-12\",\"END_DATE\":\"2022-09-25\"},\"TERM_3\":{\"START_DATE\":\"2022-09-25\",\"END_DATE\":\"2022-12-31\"}},{\"TERM_1\":{\"START_DATE\":\"2023-01-01\",\"END_DATE\":\"2023-04-30\"},\"TERM_2\":{\"START_DATE\":\"2023-05-01\",\"END_DATE\":\"2023-08-31\"},\"TERM_3\":{\"START_DATE\":\"2023-09-01\",\"END_DATE\":\"2023-12-31\"}},{\"TERM_1\":{\"START_DATE\":\"2024-01-01\",\"END_DATE\":\"2024-04-30\"},\"TERM_2\":{\"START_DATE\":\"2024-05-01\",\"END_DATE\":\"2024-08-31\"},\"TERM_3\":{\"START_DATE\":\"2024-09-01\",\"END_DATE\":\"2024-12-31\"}}]', 10),
('payment details', '[]', 11),
('expense categories', '[]', 12),
('departments', '[]', 13),
('libraries', '[{\"id\":\"1\",\"Name\":\"Primary Library\"}]', 14);

-- --------------------------------------------------------

--
-- Table structure for table `sms_api`
--

CREATE TABLE `sms_api` (
  `sms_api_key` varchar(2000) NOT NULL,
  `patner_id` varchar(2000) NOT NULL,
  `short_code` varchar(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `send_sms_url` varchar(1000) DEFAULT NULL
);

--
-- Dumping data for table `sms_api`
--

INSERT INTO `sms_api` (`sms_api_key`, `patner_id`, `short_code`, `username`, `user_id`, `send_sms_url`) VALUES
('c495f4ec19357b49b5a5a6d47b86f97c', '700', 'LADYBIRD', 'softtech', 1, 'https://isms.celcomafrica.com/api/services/sendsms');

-- --------------------------------------------------------

--
-- Table structure for table `sms_table`
--

CREATE TABLE `sms_table` (
  `send_id` int(11) NOT NULL,
  `message_count` int(11) NOT NULL,
  `message_sent_succesfully` int(11) NOT NULL,
  `message_undelivered` int(11) NOT NULL,
  `message_type` varchar(100) NOT NULL,
  `sender_no` varchar(255) DEFAULT NULL,
  `message_description` varchar(100) NOT NULL,
  `number_collection` varchar(5000) NOT NULL DEFAULT '[]',
  `message` varchar(1000) NOT NULL,
  `charged` int(11) NOT NULL DEFAULT 0,
  `date_sent` date DEFAULT NULL
);

--
-- Table structure for table `student_data`
--

CREATE TABLE `student_data` (
  `surname` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `second_name` varchar(100) DEFAULT NULL,
  `index_no` varchar(300) DEFAULT '0',
  `D_O_B` date DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `stud_class` varchar(300) DEFAULT NULL,
  `adm_no` varchar(200) NOT NULL,
  `assesment_number` varchar(500) DEFAULT NULL,
  `D_O_A` date DEFAULT NULL,
  `parentName` varchar(100) DEFAULT NULL,
  `parentContacts` varchar(100) DEFAULT NULL,
  `parent_relation` varchar(30) DEFAULT NULL,
  `parent_email` varchar(100) DEFAULT NULL,
  `parent_name2` varchar(100) DEFAULT NULL,
  `parent_contact2` varchar(200) DEFAULT NULL,
  `parent_relation2` varchar(200) DEFAULT NULL,
  `parent_email2` varchar(200) DEFAULT NULL,
  `address` varchar(100) DEFAULT 'N/A',
  `BCNo` varchar(30) DEFAULT '0',
  `student_upi` varchar(30) DEFAULT NULL,
  `admissionessentials` varchar(100) DEFAULT NULL,
  `dormitory` varchar(100) DEFAULT 'none',
  `boarding` varchar(10) DEFAULT 'none',
  `examInterview` varchar(10) DEFAULT 'NO',
  `disabled` varchar(5) DEFAULT 'No',
  `disable_describe` mediumtext DEFAULT NULL,
  `deleted` int(11) DEFAULT 0,
  `activated` int(11) DEFAULT 1,
  `ids` int(11) NOT NULL,
  `year_of_study` mediumtext DEFAULT NULL,
  `primary_parent_occupation` varchar(255) DEFAULT NULL,
  `secondary_parent_occupation` varchar(255) DEFAULT NULL,
  `prev_sch_attended` mediumtext DEFAULT NULL,
  `medical_history` mediumtext DEFAULT NULL,
  `source_funding` varchar(255) DEFAULT NULL,
  `clubs_id` varchar(500) DEFAULT NULL,
  `student_image` mediumtext DEFAULT NULL,
  `transfered_comment` mediumtext DEFAULT NULL,
  `discount_percentage` varchar(255) DEFAULT '0',
  `discount_value` varchar(255) DEFAULT '0',
  `portal_password` varchar(500) DEFAULT 'null',
  `primary_parent_password` varchar(500) DEFAULT 'null',
  `secondary_parent_password` varchar(500) DEFAULT 'null',
  `subjects_attempting` varchar(2000) NOT NULL DEFAULT '[]',
  `votehead_status` varchar(5000) NOT NULL DEFAULT '[]'
);

CREATE TABLE `table_subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `display_name` varchar(500) DEFAULT NULL,
  `timetable_id` varchar(10) DEFAULT NULL,
  `max_marks` int(11) DEFAULT NULL,
  `classes_taught` mediumtext DEFAULT NULL,
  `teachers_id` mediumtext DEFAULT NULL,
  `sub_activated` int(11) DEFAULT NULL,
  `grading` mediumtext DEFAULT NULL
);

--
-- Table structure for table `tblnotification`
--

CREATE TABLE `tblnotification` (
  `notification_id` int(11) NOT NULL,
  `notification_name` varchar(1000) DEFAULT NULL,
  `Notification_content` mediumtext DEFAULT NULL,
  `sender_id` varchar(30) DEFAULT NULL,
  `notification_status` varchar(2) DEFAULT NULL,
  `notification_reciever_id` varchar(25) DEFAULT NULL,
  `notification_reciever_auth` varchar(255) DEFAULT NULL
);

--
-- Table structure for table `template_messages`
--

CREATE TABLE `template_messages` (
  `message_id` int(11) NOT NULL,
  `message_type` varchar(500) NOT NULL,
  `message_content` varchar(2000) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `date_updated` varchar(20) NOT NULL
);

--
-- Table structure for table `transport_enrolled_students`
--

CREATE TABLE `transport_enrolled_students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `stoppage` varchar(200) DEFAULT NULL,
  `date_of_reg` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `deregistered` varchar(2000) DEFAULT NULL
);

--
-- Table structure for table `van_routes`
--

CREATE TABLE `van_routes` (
  `route_id` int(11) NOT NULL,
  `route_name` varchar(200) DEFAULT NULL,
  `route_price` int(11) DEFAULT NULL,
  `route_areas` varchar(2000) DEFAULT NULL,
  `route_vans` varchar(500) DEFAULT NULL,
  `route_status` int(11) DEFAULT NULL,
  `route_date_change` varchar(300) DEFAULT NULL,
  `route_prev_price` int(11) DEFAULT NULL
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_pay`
--
ALTER TABLE `advance_pay`
  ADD PRIMARY KEY (`advance_id`);

--
-- Indexes for table `apply_leave`
--
ALTER TABLE `apply_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendancetable`
--
ALTER TABLE `attendancetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `behaviour_comment`
--
ALTER TABLE `behaviour_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `behaviour_goal`
--
ALTER TABLE `behaviour_goal`
  ADD PRIMARY KEY (`behaviour_goal_id`);

--
-- Indexes for table `behaviour_objective`
--
ALTER TABLE `behaviour_objective`
  ADD PRIMARY KEY (`behaviour_objective_id`);

--
-- Indexes for table `behaviour_scores`
--
ALTER TABLE `behaviour_scores`
  ADD PRIMARY KEY (`behaviour_scores_id`);

--
-- Indexes for table `boarding_list`
--
ALTER TABLE `boarding_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_circulation`
--
ALTER TABLE `book_circulation`
  ADD PRIMARY KEY (`circulation_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `dorm_list`
--
ALTER TABLE `dorm_list`
  ADD PRIMARY KEY (`dorm_id`);

--
-- Indexes for table `email_address`
--
ALTER TABLE `email_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams_tbl`
--
ALTER TABLE `exams_tbl`
  ADD PRIMARY KEY (`exams_id`);

--
-- Indexes for table `exam_record_tbl`
--
ALTER TABLE `exam_record_tbl`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expid`);

--
-- Indexes for table `fees_credit_note`
--
ALTER TABLE `fees_credit_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_structure`
--
ALTER TABLE `fees_structure`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `leave_categories`
--
ALTER TABLE `leave_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_plan`
--
ALTER TABLE `lesson_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_details`
--
ALTER TABLE `library_details`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `library_notifications`
--
ALTER TABLE `library_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_n_alert`
--
ALTER TABLE `message_n_alert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mpesa_transactions`
--
ALTER TABLE `mpesa_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `parent_account_payment`
--
ALTER TABLE `parent_account_payment`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `payroll_information`
--
ALTER TABLE `payroll_information`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `questionbanks`
--
ALTER TABLE `questionbanks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_payment`
--
ALTER TABLE `salary_payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `school_vans`
--
ALTER TABLE `school_vans`
  ADD PRIMARY KEY (`van_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `sms_table`
--
ALTER TABLE `sms_table`
  ADD PRIMARY KEY (`send_id`);

--
-- Indexes for table `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `table_subject`
--
ALTER TABLE `table_subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tblnotification`
--
ALTER TABLE `tblnotification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `template_messages`
--
ALTER TABLE `template_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `transport_enrolled_students`
--
ALTER TABLE `transport_enrolled_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `van_routes`
--
ALTER TABLE `van_routes`
  ADD PRIMARY KEY (`route_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `advance_pay`
--
ALTER TABLE `advance_pay`
  MODIFY `advance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `apply_leave`
--
ALTER TABLE `apply_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `attendancetable`
--
ALTER TABLE `attendancetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `behaviour_comment`
--
ALTER TABLE `behaviour_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `behaviour_goal`
--
ALTER TABLE `behaviour_goal`
  MODIFY `behaviour_goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `behaviour_objective`
--
ALTER TABLE `behaviour_objective`
  MODIFY `behaviour_objective_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `behaviour_scores`
--
ALTER TABLE `behaviour_scores`
  MODIFY `behaviour_scores_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `boarding_list`
--
ALTER TABLE `boarding_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `book_circulation`
--
ALTER TABLE `book_circulation`
  MODIFY `circulation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `dorm_list`
--
ALTER TABLE `dorm_list`
  MODIFY `dorm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `email_address`
--
ALTER TABLE `email_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `exams_tbl`
--
ALTER TABLE `exams_tbl`
  MODIFY `exams_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `exam_record_tbl`
--
ALTER TABLE `exam_record_tbl`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `fees_credit_note`
--
ALTER TABLE `fees_credit_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `fees_structure`
--
ALTER TABLE `fees_structure`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `finance`
--
ALTER TABLE `finance`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `leave_categories`
--
ALTER TABLE `leave_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `lesson_plan`
--
ALTER TABLE `lesson_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `library_details`
--
ALTER TABLE `library_details`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `library_notifications`
--
ALTER TABLE `library_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `message_n_alert`
--
ALTER TABLE `message_n_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `mpesa_transactions`
--
ALTER TABLE `mpesa_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `parent_account_payment`
--
ALTER TABLE `parent_account_payment`
  MODIFY `transaction_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `payroll_information`
--
ALTER TABLE `payroll_information`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `questionbanks`
--
ALTER TABLE `questionbanks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `salary_payment`
--
ALTER TABLE `salary_payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `sms_api`
--
ALTER TABLE `sms_api`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `sms_table`
--
ALTER TABLE `sms_table`
  MODIFY `send_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `student_data`
--
ALTER TABLE `student_data`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `table_subject`
--
ALTER TABLE `table_subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tblnotification`
--
ALTER TABLE `tblnotification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `template_messages`
--
ALTER TABLE `template_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `transport_enrolled_students`
--
ALTER TABLE `transport_enrolled_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
