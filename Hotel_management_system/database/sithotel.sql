SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

--
-- Database: `sithotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `account_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `gender` enum('male', 'female', 'other') NOT NULL,
  `country` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`account_id`, `name`, `email`, `password`, `mobile`, `gender`, `country`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 91234567, 'male', 'Singapore'),
(2, 'John Doe', 'john.doe@example.com', 'password123', 98765432, 'male', 'Malaysia'),
(3, 'Jane Smith', 'jane.smith@example.com', 'securepass', 87654321, 'female', 'China'),
(4, 'Chris Johnson', 'chris.johnson@example.com', 'pass123', 76543210, 'male', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `room_id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `details` text NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `quantity` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`room_id`, `type`, `price`, `details`, `image`, `quantity`) VALUES
(1, 'Standard Room', 50, 'Our standard rooms provide a comfortable and cozy retreat for one or two guests. These rooms typically feature a queen or king-sized bed, a private bathroom, a TV, a desk, and all the essential amenities you need for a pleasant stay.', 'standard.jpg', 3),
(2, 'Suite', 60, 'Indulge in luxury with our spacious suites, offering a blend of style and comfort. Our suites feature a separate living area and bedroom, ideal for relaxation or business, and often include a well-equipped kitchenette or full kitchen.', 'suite.jpg', 3),
(3, 'Deluxe Room', 70, 'Elevate your stay with our Deluxe Rooms, offering a touch of luxury and extra space. These well-appointed rooms feature upgraded amenities and a more spacious layout compared to our standard rooms, ensuring a comfortable and enjoyable stay.', 'deluxe.jpg', 3),
(4, 'Junior Suite', 80, 'Experience a blend of comfort and style in our Junior Suites. These mid-sized suites provide a separate sitting area and bedroom, offering more space and privacy. With amenities like a work desk and additional seating, our Junior Suites are designed to cater to both business and leisure travelers.', 'junior.jpg', 3),
(5, 'Executive Room', 90, 'Discover the convenience and amenities of our Executive Rooms, designed to meet the needs of business travelers and guests seeking additional comfort. These rooms often include a dedicated work desk and access to the executive lounge, providing complimentary services such as breakfast, refreshments, and private meeting spaces.', 'executive.jpg', 3),
(6, 'Family Room', 100, 'Enjoy a family-friendly stay in our spacious Family Rooms, thoughtfully designed to accommodate groups or families. These rooms often feature extra sleeping arrangements, such as pull-out sofas or additional beds, making them perfect for traveling with children or in larger groups.', 'family.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Booking`
--

CREATE TABLE `Booking` (
  `booking_id` INT AUTO_INCREMENT PRIMARY KEY,
  `account_id` INT NOT NULL,
  `room_id` INT NOT NULL,
  `check_in_date` DATE NOT NULL,
  `check_out_date` DATE NOT NULL,
  CHECK(check_out_date >= check_in_date),
  FOREIGN KEY (account_id) REFERENCES Account(account_id) ON DELETE CASCADE,
  FOREIGN KEY (room_id) REFERENCES Rooms(room_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `Booking`
--

INSERT INTO `Booking` (`account_id`, `room_id`, `check_in_date`, `check_out_date`) VALUES
(4, 2, '2023-06-15', '2023-06-20'),
(2, 4, '2023-07-10', '2023-07-15'),
(3, 1, '2023-08-05', '2023-08-10'),
(4, 5, '2023-09-01', '2023-09-05'),
(2, 3, '2023-09-15', '2023-09-20'),
(3, 6, '2023-10-10', '2023-10-15'),
(2, 5, '2023-10-10', '2023-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `booking_id` INT NOT NULL,
  `payment_date` DATE NOT NULL,
  `payment_amount` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (booking_id),
  FOREIGN KEY (booking_id) REFERENCES Booking(booking_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`booking_id`, `payment_date`, `payment_amount`) VALUES
(1, '2023-06-18', 300),
(2, '2023-07-12', 400),
(3, '2023-08-07', 250),
(4, '2023-09-03', 360),
(5, '2023-09-17', 350),
(6, '2023-10-12', 500),
(7, '2023-10-04', 810);