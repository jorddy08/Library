-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 02:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `created_at`, `first_name`, `last_name`, `middle_initial`) VALUES
(4, 'Jezreel', '$2y$10$NH/bP/uKNbpAUF3xIDA0de4.u4g9jgvnOHLz2NhrX60FFu.vra/b6', 'jezreelvillanueva@gmail.com', '2025-05-22 07:54:10', 'Jezreel', 'Villanueva', ''),
(5, 'Ken', '$2y$10$NhqxD392n6dhmrNKZ2nDleuKh3aZmdaiD76mr.nubGPAIP9aIMHkK', 'kennethventurado@gmail.com', '2025-05-22 07:55:18', 'Kenneth', 'Venturado', ''),
(6, 'Jordan', '$2y$10$BEPpBTnW7Rbd3BO.K3/xjO26KFw688M/vAG8tNsvwZOcDdqL5lIWK', 'jordanherrera@gmail.com', '2025-05-22 07:57:59', 'Jordan', 'Herrera', ''),
(7, 'Lester', '$2y$10$peGnaa7ORI9rhDQLXbK3iuwa6Cct91E74FMMdvmMmoKG1jeOxr8pi', 'lestercustodio@gmail.con', '2025-05-24 02:19:03', 'Lester', 'Custodio', ''),
(8, 'Joshua', '$2y$10$GQ/xUutu6e/GW/i21IC9jO1Z2WE39GhK/1fN2x2aneMWdzT0PZqaS', 'joshuaherrera@gmail.com', '2025-05-26 07:23:16', 'Joshua', 'Herrera', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(10, 'C.S. Lewis'),
(4, 'F. Scott Fitzgerald'),
(2, 'George Orwell'),
(1, 'Harper Lee'),
(5, 'Herman Melville'),
(7, 'J.D. Salinger'),
(8, 'J.R.R. Tolkien'),
(3, 'Jane Austen'),
(6, 'Leo Tolstoy'),
(9, 'Ray Bradbury');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `location`, `image`, `description`, `category_id`, `category_name`) VALUES
(12, 'To Kill a Mockingbird', 'Harper Lee', 'Shelf A1', '682ebbcaa0daa.jpg', 'A profound novel set in the Deep South that explores themes of racial injustice, moral growth, and compassion through the eyes of young Scout Finch.', 1, 'Classic Fiction'),
(13, '1984', 'George Orwell', 'Shelf A2', '682ebbe87cc88.jpg', 'A dystopian classic depicting a totalitarian society under constant surveillance, where truth is manipulated and individuality crushed.', 2, 'Science Fiction / Dystopian'),
(15, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Shelf B2', '682ebc464762f.jpg', 'An evocative portrayal of the Jazz Age, wealth, and the American Dream through the tragic story of Jay Gatsby and his unrequited love for Daisy Buchanan.', 1, 'Classic Fiction'),
(16, 'Moby Dick', 'Herman Melville', 'Shelf C1', '682ebc60d41cf.png', 'An epic and symbolic adventure chronicling Captain Ahab’s obsessive quest for revenge against the elusive white whale, exploring themes of fate, nature, and madness.', 1, 'Classic Fiction'),
(17, 'War and Peace', 'Leo Tolstoy', 'Shelf C2', '682ebc8020b31.jpg', 'A sweeping historical novel intertwining the lives of aristocratic families against the backdrop of the Napoleonic Wars, reflecting on war, peace, and human nature.', 4, 'Historical Fiction'),
(18, 'The Catcher in the Rye', 'J.D. Salinger', 'Shelf D1', '682ebc9590c29.jpg', 'A compelling coming-of-age story revealing the struggles of adolescent Holden Caulfield as he deals with alienation, identity, and loss in post-war America.', 1, 'Classic Fiction'),
(19, 'The Hobbit', 'J.R.R. Tolkien', 'Shelf D2', '682ebcb819fa0.jpg', 'A richly imagined fantasy tale following Bilbo Baggins on a daring adventure filled with dragons, dwarves, and unexpected heroism in Middle-earth.', 3, 'Fantasy'),
(20, 'Fahrenheit 451', 'Ray Bradbury', 'Shelf E1', '682ebcd2f1de4.jpg', 'A powerful dystopian narrative warning against censorship and the suppression of ideas, centered on a future society where books are banned and burned.', 2, 'Science Fiction / Dystopian'),
(21, 'The Chronicles of Narnia', 'C.S. Lewis', 'Shelf E2', '682ebce712e5c.jpg', 'A beloved fantasy series exploring themes of bravery, faith, and imagination through the magical adventures of children in the enchanted land of Narnia.', 3, 'Fantasy'),
(23, 'The Smile', 'Ray Bradbury', 'Shelf D2', '682f1562aff1f.jpg', 'The Smile is a thought-provoking short story by Ray Bradbury that explores the power of art and beauty in a dystopian future. Set in a post-apocalyptic world where knowledge and culture have been largely destroyed, the story centers around a man who discovers a famous painting, Mona Lisa, preserved beneath the rubble.', 2, 'Science Fiction / Dystopian'),
(32, 'Prince Caspian', 'C.S. Lewis', 'Shelf D2', '68341bd830e4c.jpg', 'Prince Caspian is the second published book in The Chronicles of Narnia series and the fourth in the chronological order of the story. This novel continues the enchanting saga of the magical land of Narnia, a place where animals talk, magic is real, and the battle between good and evil unfolds on a grand scale.', 1, 'Classic Fiction'),
(33, 'The Voyage of the Dawn Treader', 'C.S. Lewis', 'Shelf D2', '68341c3e56351.jpg', 'The Voyage of the Dawn Treader is the third published book in The Chronicles of Narnia series and the fifth chronologically. This enchanting novel takes readers on an epic seafaring adventure filled with magic, mystery, and profound personal discovery. It stands out in the series for its spirit of exploration and the diverse, fantastical islands the characters visit, each with its own unique challenges and lessons.', 1, 'Classic Fiction'),
(35, 'The Great Divorce', 'C.S. Lewis', 'Shelf D2', '68341d008a60a.jpg', 'While not exactly historical fiction, this allegorical novel explores spiritual themes through a fantastical journey resembling an afterlife experience. It reflects on Christian theology, morality, and the nature of heaven and hell, set in a timeless, otherworldly setting rather than a specific historical period.', 4, 'Historical Fiction'),
(36, 'Till We Have Faces', 'C.S. Lewis', 'Shelf D2', '68341d2cd6967.jpg', 'This is the closest to historical fiction in Lewis’s work. It’s a retelling of the ancient myth of Cupid and Psyche, set in a fictional ancient kingdom resembling classical antiquity. The novel explores themes of love, faith, and the human relationship with the divine. Though mythological rather than strictly historical, it’s set in a world inspired by ancient times, blending myth with deep psychological and philosophical insight.', 4, 'Historical Fiction'),
(37, 'The Curious Case of Benjamin Button', 'F. Scott Fitzgerald', 'Shelf E1', '68341de5d8e48.jpg', 'is a unique and imaginative short story about a man who is born with the physical appearance and ailments of an old man and ages in reverse—growing younger as time passes. The story follows Benjamin’s unusual life journey, exploring how this extraordinary condition affects his relationships, identity, and place in society. Blending fantasy with poignant reflections on aging, time, and the human experience, the story challenges conventional ideas about life’s natural course and offers a bittersweet meditation on the passage of time.', 3, 'Fantasy'),
(38, 'The Diamond as Big as the Ritz', 'F. Scott Fitzgerald', 'Shelf E1', '68341e6c51892.jpg', '“The Diamond as Big as the Ritz” is a captivating and satirical novella that combines fantasy, adventure, and social critique. The story follows John T. Unger, a wealthy and idealistic young man from a privileged East Coast family, who is sent to a prestigious boarding school in the mountains of Montana. There, he meets the enigmatic Percy Washington and is invited to visit Percy’s family estate—an incredible, secret mountain made almost entirely of solid diamond.', 3, 'Fantasy'),
(39, 'Animal Farm', 'George Orwell', 'Shelf  A1', '68341f6882195.jpg', 'While technically an allegorical novella rather than pure sci-fi, Animal Farm uses anthropomorphic animals to tell a political fable about the rise of totalitarianism and the corruption of revolutionary ideals. It’s often studied alongside dystopian literature.', 2, 'Science Fiction / Dystopian'),
(40, 'Coming Up for Air', 'George Orwell', 'Shelf  A1', '68341f951c308.jpg', 'This novel isn’t strictly science fiction but includes some speculative elements reflecting anxieties about impending war and societal change in pre-WWII England.', 2, 'Science Fiction / Dystopian'),
(41, 'Go Set a Watchman', 'Harper Lee', 'Shelf B1', '683420de3dbb1.jpg', 'Set about 20 years after To Kill a Mockingbird, it follows an adult Scout (Jean Louise) as she returns to her hometown and confronts difficult truths about her father and the racial tensions of the South.', 4, 'Historical Fiction'),
(42, 'The Piazza Tales', 'Herman Melville', 'Shelf B1', '6834226edec37.jpg', 'The Piazza Tales is Melville’s only short story collection published during his lifetime. The stories reflect his deep concern with human isolation, moral ambiguity, the unknown, and the thin line between reality and illusion. While grounded in 19th-century settings, many of the tales take on a dreamlike or fantastical tone, echoing themes of myth, fate, and existential mystery.', 3, 'Fantasy'),
(43, 'Billy Budd, Sailor', 'Herman Melville', 'Shelf B1', '683422dc23ec4.jpg', 'Billy Budd, Sailor is Herman Melville’s final work and is widely regarded as a masterful allegorical novella. The story centers around a young, handsome, and kind-hearted sailor named Billy Budd, who is conscripted into service aboard a British warship, the HMS Bellipotent. Despite his good nature and physical beauty, Billy becomes the tragic focus of conflict when he is falsely accused of mutiny by the malevolent John Claggart, the ship’s Master-at-Arms.', 3, 'Fantasy'),
(45, 'For Esmé—with Love and Squalor', 'J.D. Salinger', 'Shelf J1', '6834240b546f4.jpg', '“For Esmé—with Love and Squalor” is a poignant, two-part short story that contrasts innocence and beauty with the trauma and emotional decay of war. The narrator, a U.S. soldier stationed in England during World War II, recounts a brief but deeply meaningful encounter with a young English girl named Esmé, and how her kindness helps sustain him through the psychological horrors of combat.', 4, 'Historical Fiction'),
(46, 'The Catcher in the Rye', 'J.D. Salinger', 'Shelf  J2', '683424d059b4e.jpg', 'The Catcher in the Rye is a deeply influential novel that explores themes of adolescence, identity, alienation, and the struggle to preserve innocence. The story is told through the eyes of Holden Caulfield, a disenchanted teenager who has just been expelled from yet another prep school.', 4, 'Historical Fiction'),
(47, 'The Lord of the Rings Trilogy', 'J.R.R. Tolkien', 'Shelf  Z1', '683425de1dfa8.jpg', 'The Lord of the Rings is an epic tale of adventure, friendship, and the struggle between good and evil set in the richly detailed world of Middle-earth. The story follows a young hobbit, Frodo Baggins, who inherits a powerful and dangerous artifact known as the One Ring — a symbol of ultimate evil forged by the Dark Lord Sauron to control all life.', 3, 'Fantasy'),
(48, 'The Silmarillion', 'J.R.R. Tolkien', 'Shelf T1', '6834264c3a784.jpg', 'The Silmarillion is a collection of mythic stories, legends, and histories that form the deep background and foundation for Tolkien’s entire Middle-earth legendarium. It’s often described as Tolkien’s “creation myth” for his fantasy world, detailing the origins of the universe, the rise and fall of powerful beings, and the epic conflicts that shape the world.', 3, 'Fantasy'),
(49, 'Fahrenheit 451', 'Ray Bradbury', 'Shelf  H1', '683427574d23b.jpg', 'Fahrenheit 451 is a dystopian novel set in a future society where books are banned and \"firemen\" burn any that are found. The story follows Guy Montag, a fireman who becomes disillusioned with this anti-intellectual world. As he begins to question the purpose of his job and the society’s suppression of knowledge, Montag embarks on a journey of self-discovery and rebellion against censorship and conformity.', 2, 'Science Fiction / Dystopian'),
(50, 'Pride and Prejudice', 'Jane Austen', 'Shelf T2', '683428ea26138.jpg', 'Pride and Prejudice is a classic romantic novel set in early 19th-century England. It centers on Elizabeth Bennet, a sharp and independent young woman, and her evolving relationship with the wealthy and reserved Mr. Darcy. The story explores themes of love, social class, misunderstandings, and personal growth as Elizabeth and Darcy overcome their initial judgments and pride to find mutual respect and affection.', 1, 'Classic Fiction'),
(51, 'Sense and Sensibility', 'Jane Austen', 'Shelf  T1', '6834292f6e0c2.jpg', 'Sense and Sensibility follows the lives of the Dashwood sisters, Elinor and Marianne, after their family loses its fortune and they must navigate love, heartbreak, and social challenges. Elinor represents \"sense\" with her practicality and restraint, while Marianne embodies \"sensibility\" through her emotional openness and impulsiveness. The novel explores themes of love, duty, class, and the balance between reason and emotion in relationships and life.', 1, 'Classic Fiction'),
(52, 'Anna Karenina', 'Leo Tolstoy', 'Shelf  E1', '68342a1cd609b.jpg', 'Anna Karenina is a tragic novel set in 19th-century Russian high society. It tells the story of Anna, a beautiful and aristocratic woman who enters into a passionate but socially scandalous affair with the dashing Count Vronsky. Torn between her desires and the rigid moral expectations of her time, Anna’s life unravels amid love, jealousy, and societal judgment.', 1, 'Classic Fiction'),
(53, 'Resurrection', 'Leo Tolstoy', 'Shelf  O1', '68342a55e9db8.jpg', 'Resurrection is a powerful novel that explores themes of guilt, redemption, and social justice. The story follows Dmitri Ivanovich, a nobleman who recognizes his moral failings when he encounters Katerina Maslova, a woman he once wronged and who has since fallen into a life of hardship and imprisonment. Driven by guilt, Dmitri seeks to atone for his past mistakes by helping Katerina, leading him on a journey of spiritual awakening and self-redemption.', 1, 'Classic Fiction'),
(54, 'Emma', 'Jane Austen', 'Shelf  S1', '68342be53046b.jpg', 'Emma is a charming and witty novel about Emma Woodhouse, a confident and somewhat spoiled young woman who delights in matchmaking among her friends and acquaintances. Despite her good intentions, Emma’s meddling often leads to misunderstandings and complications, especially in matters of love and friendship. Over time, she learns important lessons about humility, self-awareness, and true affection.', 1, 'Classic Fiction'),
(55, 'Mansfield Park', 'Jane Austen', 'Shelf S1', '68342c28b64c4.jpg', 'Mansfield Park follows the story of Fanny Price, a shy and modest young woman sent to live with her wealthy relatives at Mansfield Park. As she grows up amidst the privileges and intrigues of the Bertram family, Fanny’s strong moral compass and quiet strength stand in contrast to the more flamboyant characters around her. The novel explores themes of social class, morality, family dynamics, and the complexities of love and duty.', 1, 'Classic Fiction'),
(56, 'Northanger Abbey', 'Jane Austen', 'Shelf  R1', '68342c5f274c5.jpg', 'Northanger Abbey is a playful and satirical novel that follows Catherine Morland, a young and impressionable woman who loves reading Gothic novels. When she visits the mysterious Northanger Abbey with new acquaintances, her imagination runs wild, leading her to suspect dark secrets and intrigue where there are none. Through Catherine’s adventures, the novel humorously critiques the conventions of Gothic fiction and explores themes of innocence, imagination, and the process of maturing.', 1, 'Classic Fiction'),
(57, 'Persuasion', 'Jane Austen', 'Shelf W1', '68342c9fa507e.jpg', 'Persuasion tells the story of Anne Elliot, a gentle and thoughtful woman who, years earlier, was persuaded to break off her engagement to the man she loved, Captain Frederick Wentworth, due to his lack of fortune and uncertain future. Now, eight years later, fate brings them back together, and Anne must navigate feelings of regret, hope, and second chances.', 1, 'Classic Fiction'),
(58, 'This Side of Paradise', 'F. Scott Fitzgerald', 'Shelf G2', '68342d2d1e9b4.jpg', 'This Side of Paradise is a coming-of-age novel that follows Amory Blaine, a young, ambitious, and somewhat arrogant man navigating life, love, and identity in post-World War I America. Through his experiences at prep school, Princeton University, and in relationships, Amory explores themes of youth, idealism, disillusionment, and the search for meaning in a rapidly changing society.', 1, 'Classic Fiction'),
(59, 'Tender Is the Night', 'F. Scott Fitzgerald', 'Shelf G2', '68342d577d2fd.jpg', 'Tender Is the Night is a tragic and complex novel that centers on the glamorous yet troubled lives of Dick and Nicole Diver, a wealthy American couple living on the French Riviera in the 1920s. The story explores their passionate but ultimately destructive marriage, highlighting themes of love, mental illness, betrayal, and the decay beneath the glittering surface of the expatriate elite.', 1, 'Classic Fiction'),
(61, 'Nine Stories', 'J.D. Salinger', 'Shelf H2', '68342ddc34281.jpg', 'Nine Stories is a collection of short stories by J.D. Salinger that explores themes of innocence, loss, human connection, and the complexities of life. The stories often focus on moments of profound emotional insight and the struggles of characters to find meaning or understanding in a sometimes confusing world. Notable stories include “A Perfect Day for Bananafish,” which delves into trauma and isolation, and “For Esmé—with Love and Squalor,” a poignant tale of compassion and healing.', 1, 'Classic Fiction'),
(62, 'Franny and Zooey', 'J.D. Salinger', 'Shelf H1', '68342e07ac8f2.jpg', 'Franny and Zooey is a novel that combines two interconnected stories about the Glass family siblings, Franny and Zooey Glass. The first part, \"Franny,\" follows the young college student Franny as she experiences a spiritual and existential crisis, struggling with the superficiality she sees around her. The second part, \"Zooey,\" centers on her older brother Zooey, who tries to help her find clarity and peace.', 1, 'Classic Fiction'),
(63, 'The Space Trilogy', 'C.S. Lewis', 'Shelf J2', '68342e680b206.jpg', 'The Space Trilogy (also known as the Cosmic Trilogy) is a series of three science fiction novels: Out of the Silent Planet, Perelandra, and That Hideous Strength. The trilogy follows the adventures of Dr. Elwin Ransom, who travels to other planets and encounters alien civilizations. The series combines imaginative space exploration with deep philosophical and theological themes, including the nature of good and evil, humanity’s place in the universe, and spiritual redemption.', 1, 'Classic Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Classic Fiction'),
(2, 'Science Fiction / Dystopian'),
(3, 'Fantasy'),
(4, 'Historical Fiction');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
