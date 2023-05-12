SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `webfilm`
-- 

-- --------------------------------------------------------
CREATE DATABASE `webfilm`;

USE `webfilm`;

CREATE TABLE `Admin`
(
  `Usernames` VARCHAR(50) NOT NULL,
  `PWD` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Usernames`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Genres`
(
  `MaTL` INT AUTO_INCREMENT,
  `Genre` NVARCHAR(50) NOT NULL,
  PRIMARY KEY (`MaTL`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Users`
(
  `MaUser` INT AUTO_INCREMENT,
  `Username` VARCHAR(30) NOT NULL,
  `PWD` VARCHAR(30) NOT NULL,
  `Gmail` VARCHAR(30) NOT NULL,
  `OTP` INT DEFAULT NULL,
  PRIMARY KEY (`MaUser`),
  UNIQUE (`Gmail`),
  UNIQUE(`Username`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Film`
(
  `MaF` INT AUTO_INCREMENT,
  `Names` NVARCHAR(50) NOT NULL,
  `Actor` NVARCHAR(100) NOT NULL,
  `Director` NVARCHAR(100) NOT NULL,
  `Rating` TINYINT NOT NULL,
  `Descr` NVARCHAR(1000) NOT NULL,
  `Images` VARCHAR(100) NOT NULL,
  `Trailer` VARCHAR(255) NOT NULL,
  `Age` TINYINT NOT NULL,
  `Years` INT NOT NULL,
  PRIMARY KEY (`MaF`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Film_Genre`
(
  `MaF` INT NOT NULL,
  `MaTL` INT NOT NULL,
  PRIMARY KEY (`MaTL`, `MaF`),
  FOREIGN KEY (`MaTL`) REFERENCES `Genres`(`MaTL`),
  FOREIGN KEY (`MaF`) REFERENCES `Film`(`MaF`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Comment`
(
  `MaBL` INT AUTO_INCREMENT,
  `MaUser` INT NOT NULL,
  `MaF` INT NOT NULL,
  `Content` NVARCHAR(1000) NOT NULL,
  `Times` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`MaBL`, `MaUser`, `MaF`),
  FOREIGN KEY (`MaUser`) REFERENCES `Users`(`MaUser`),
  FOREIGN KEY (`MaF`) REFERENCES `Film`(`MaF`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Favorite`
(
  `MaUser` INT NOT NULL,
  `MaF` INT NOT NULL,
  PRIMARY KEY (`MaUser`, `MaF`),
  FOREIGN KEY (`MaUser`) REFERENCES `Users`(`MaUser`),
  FOREIGN KEY (`MaF`) REFERENCES `Film`(`MaF`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `Admin` (`Usernames`, `PWD`) VALUES
('Admin', '123456');
-- INSERT GENRES
INSERT INTO `Genres` (`Genre`) VALUES 
(N'HÀNH ĐỘNG'),
(N'NHẠC PHIM'),
(N'HÀI'),
(N'KHOA HỌC VIỄN TƯỞNG'),
(N'KINH DỊ'),
(N'TÌNH CẢM'),
(N'CHIẾN TRANH'),
(N'HOẠT HÌNH'),
(N'TỘI PHẠM'),
(N'SIÊU ANH HÙNG');

-- INSERT USERS
INSERT INTO `Users` (`Username`, `PWD`, `Gmail`, `OTP`) VALUES
('nguyenvana', '12345678', 'nguyenvana@gmail.com', null),
('nguyenvanb', '12345678', 'nguyenvanb@gmail.com', null),
('nguyenthic', '12345678', 'nguyenthic@gmail.com', null),
('nguyenthid', 'abc12345', 'nguyenthid@gmail.com', null),
('nguyenthit', '12345678', 'nguyenthit@gmail.com', null);

INSERT INTO `Film` (`Names`, `Actor`, `Director`, `Rating`, `Descr`, `Images`, `Trailer`, `Age`, `Years`) VALUES 
(N'Star Wars IV: A New Hope', N'Mark Hamill, Kenny Baker, David Prowse, Phil Brown', N'George Lucas', 9, N'Chiến tranh giữa các vì sao: Tập 4 – Niềm hi vọng mới là phim điện ảnh sử thi không gian của Mỹ công chiếu năm 1977 do George Lucas làm đạo diễn kiêm biên kịch. Đây là bộ phim đầu tiên trong bộ ba tác phẩm gốc và là bộ phim đầu tiên của nhượng quyền Star Wars.', './Film/ANewHope/img.jpg', 
'http://167.114.174.132:9092/movies/Batch241/Star.Wars.Episode.IV.-.A.New.Hope.1977.720p.BluRay.x264-%5BYTS.AG%5D.mp4', 13, 1977),
(N'Black Panther', N'Chadwick Boseman, Michael B. Jordan, Lupita Nyong`o, Danai Gurira', N'Ryan Coogler', 7 , N'Avatar: Dòng chảy của nước là một bộ phim điện ảnh thuộc thể loại khoa học viễn tưởng và sử thi của Mỹ năm 2022. Tác phẩm do James Cameron đạo diễn, viết kịch bản và hợp tác sản xuất với 20th Century Studios. Đây sẽ là phần phim thứ hai trong loạt phim Avatar, sau phần một cùng tên năm 2009.', './Film/BlackPanther/img.jpg', 
'https://dl3.3rver.org/cdn2/07/film/2018/black-panther/trailer.mp4', 13, 2020),
(N'Avengers Endgame', N'Robert Downey Jr., Brie Larson, Paul Rudd, Joe Russo', N'Anthony Russo, Joe Russo', 8, N'Avengers: Hồi kết là phim điện ảnh siêu anh hùng Mỹ ra mắt năm 2019, do Marvel Studios sản xuất và Walt Disney Studios Motion Pictures phân phối độc quyền tại thị trường Bắc Mỹ.', './Film/AvengersEndgame/img.jpg', 
'https://dl3.3rver.org/cdn2/02/film/2019/The%20Avengers%3A%20Endgame/Avengers.Endgame.2019.Trailer.mp4', 13, 2019),
(N'BLACK ADAM', N'Dwayne Johnson, Noah Centineo, Aldis Hodge, Marwan Kenzari', N'Jaume Collet-Serra', 7, N'Black Adam là một bộ phim điện ảnh siêu anh hùng của Hoa Kỳ ra mắt năm 2022, dựa trên nhân vật cùng tên của DC Comics. Được sản xuất bởi New Line Cinema, DC Films, Seven Bucks Productions và Flynn Picture, đây là phần phim ngoại truyện của Shazam!, và là phim thứ 11 trong Vũ trụ Mở rộng DC.', './Film/BlackAdam/img.jpg', 
'http://mysldev.com/video/Movies/Black%20Adam%20(2022).mp4', 13, 2022),
(N'Deadpool', N'Ryan Reynolds, Ryan Reynolds, ', N'Tim Miller, Karan Soni, Rachel Sheen', 8, N'Deadpool là một bộ phim siêu anh hùng của Mỹ năm 2016 dựa trên nhân vật cùng tên của Marvel Comics. Được phát hành bởi 20th Century Fox, đây là phần phim phụ trong loạt phim X-Men và là phần thứ tám nói chung.', './Film/Deadpool/img.jpg', 
'https://dl3.3rver.org/cdn2/05/film/2016/Deadpool/Deadpool.2016.mp4', 15, 2016),
(N'Captain America', N'Chris Evansm, Tommy Lee Jones, Hugo Weaving, Hayley Atwell', N'Joe Johnston', 8, N'Steve Rogers, một người lính quân sự bị từ chối, biến thành Captain America sau khi dùng một liều "huyết thanh siêu lính". Nhưng là Captain America có giá khi anh ta cố gắng hạ gục một người ấm áp và một tổ chức khủng bố.', './Film/CaptainAmerica/img.jpg', 
'https://dl3.3rver.org/cdn2/02/film/2011/Captain%20America%3A%20The%20First%20Avenger/Captain.America.The.First.Avenger.2011.Trailer.mp4', 13, 2019),
(N'FAST AND FURIOUS 7', N'Paul Walker, Vin Diesel, Jason Statham, Dwayne Johnson', N'James Wan', 7, N'Furious 7 là một bộ phim hành động Mỹ năm 2015 của đạo diễn James Wan và được viết bởi Chris Morgan. Đây là phần tiếp theo của Fast & Furious 6 và The Fast and the Furious: Tokyo Drift, đồng thời là phần thứ bảy trong loạt phim Fast & Furious.', './Film/Fast&Furious7/img.jpg', 
'http://s4.topseda.ir/95/Video/Foreign/ff7/Trailer.mp4', 13, 2015),
(N'Logan', N'Hugh Jackman, Patrick Stewart, Richard E. Grant, Boyd Holbrook', N'James Mangold', 8, N'Trong một tương lai nơi những người đột biến gần như tuyệt chủng, một Logan già và mệt mỏi có một cuộc sống yên tĩnh. Nhưng khi Laura, một đứa trẻ đột biến bị các nhà khoa học theo đuổi, đến với anh ta để được giúp đỡ, anh ta phải đưa cô đến nơi an toàn.', './Film/Logan/img.jpg', 
'https://dl3.3rver.org/cdn2/07/film/2017/logan/trailer.mp4', 18, 1939),
(N'IROM MAN', N'Robert Downey Jr., Stan Lee, Paul Bettany, Faran Tahir', N'Shane Black, Jon Favreau', 8, N'Iron Man (tên thật là Tony Stark) là một siêu anh hùng hư cấu xuất hiện trong truyện tranh của Mỹ được xuất bản bởi Marvel Comics, cũng như các phương tiện truyền thông liên quan.', './Film/IronMen/img.jpg', 
'https://tartarus.feralhosting.com/firepig/JP/MOVIES/Iron%20Man%202008%201080p%20BluRay%20x264%20%20AAC%20-%20Ozlem/Iron%20Man%202008%201080p%20BluRay%20x264%20%20AAC%20-%20Ozlem.mp4', 13, 2008),
(N'Jurassic World', N'Bryce Dallas Howard, Vincent D’onofrio, Matthew Cardarople, Kelly Lynn Washington', N'Colin Trevorrow', 7, N'Jurassic World là một bộ phim hành động khoa học viễn tưởng của Mỹ năm 2015 do Colin Trevorrow làm đạo diễn, người đồng viết kịch bản với Rick Jaffa, Amanda Silver và Derek Connolly từ một câu chuyện của Jaffa và Silver.', './Film/JurassicWorld/img.jpg', 
'https://dl3.3rver.org/cdn2/07/film/2015/jurassic-world/Jurassic.World.trailer.mp4', 15, 2015),
(N'SMILE', N'Parker Finn, Nick Arapoglou, Perry Strong, Robin Weigert', N'Parker Finn', 7, N'Smile là một bộ phim kinh dị tâm lý của Mỹ năm 2022 do Parker Finn viết kịch bản và đạo diễn trong bộ phim đầu tay do anh ấy làm đạo diễn, dựa trên bộ phim ngắn năm 2020 Laura Has`t Slept của anh ấy.', './Film/Smile/img.jpg', 
'http://zpsgdynia.pl/download/filmy/smile/smile.mp4', 15, 2022),
(N'Spider-men: No Way Home', N'Tom Holland, Willem Dafoe, Jacob Batalon, Kirsten Dunst', N'Jon Watts', 8, N'Người Nhện: Không còn nhà là một bộ phim siêu anh hùng năm 2021 của Mỹ dựa trên nhân vật Peter Parker của Marvel Comics, do Columbia Pictures và Marvel Studios đồng sản xuất và được phân phối bởi Sony Pictures Releasing.', './Film/SpidermanNoWayHome/img.jpg', 
'https://dl3.3rver.org/cdn2/02/film/2019/Spider%20Man%20Far%20From%20Home/Spider.Man.Far.From.Home.2019.Trailer.mp4', 13, 2021),
(N'Superman', N'Henry Cavill, Christopher Reeve, Brandon Routh, Dean Cain', N'Jerry Siegel, Canada Joe Shuster', 7, N'Siêu Nhân là một nhân vật siêu anh hùng hư cấu trong loạt truyện tranh cùng tên nổi tiếng của Mỹ do hãng DC Comics phát hành. Ban đầu, Siêu Nhân do nhà văn Mỹ Jerry Siegel và nghệ sĩ gốc Canada Joe Shuster, lúc đó là những học sinh trung học sống tại Cleverland, Ohio tạo ra vào năm 1933.', './Film/Superman/img.jpg', 
'https://dl3.3rver.org/cdn2/07/film/2016/batman-v-superman-dawn-of-justice/Batman.V.Superman.trailer.mp4', 13, 1978),
(N'The Batman', N'Robert Pattinson, Andy Serkis, John Turturro, Max Carver', N'Matt Reeves', 8, N'The Batman là một bộ phim điện ảnh đề tài siêu anh hùng của Mỹ, dựa trên nhân vật cùng tên của loạt truyện tranh DC Comics.', './Film/TheBatman/img.jpg', 
'https://dl3.3rver.org/cdn2/04/film/2005/batman.begins/Batman.Begins.2005.mp4', 13, 2022),
(N'Morbius', N'Jared Leto, Matt Smith, Adria Arjona, Jared Harris, Al Madrigal', N'Daniel Espinosa', 6, N'Nhà hóa sinh Michael Morbius cố gắng tự chữa khỏi bệnh máu hiếm gặp, nhưng thay vào đó, anh ta vô tình lây nhiễm với một hình thức ma cà rồng.', './Film/Morbius/img.jpg', 
'https://dl3.3rver.org/hex2/Film/1399/01/Morbius.2021.Trailer.mp4', 13, 2018),
(N'Transformers', N'Mark Wahlberg, Josh Duhamel, Stanley Tucci, Anthony Hopkins', N'Michael Bay', 7, N'Một mối đe dọa chết người từ lịch sử Trái đất xuất hiện trở lại và một cuộc săn lùng một cổ vật bị mất diễn ra giữa Autobots và Decepticons, trong khi Optimus Prime gặp người tạo ra của anh ta trong không gian.', './Film/Transformers/img.jpg', 
'http://s4.topseda.ir/nevisande/reza/1396/video/khareji/Transformers.The.Last.Knight.2017/TRANSFORMERS%205Trailer%203%20%282017%29.mp4 ', 15, 1965),
(N'Thor', N'Chris Hemsworth, Natalie Portman, Anthony Hopkins, Idris Elba', N'Taika Waititi, Alan Taylor, Kenneth Branagh', 7, N'Thor (công chiếu ở Việt Nam với tên Thần Sấm) là một bộ phim nói về nhân vật siêu anh hùng cùng tên trong Marvel Comics. Được sản xuất bởi Marvel Studios và phân phối bởi Paramount Pictures, đây là bộ phim thứ 4 trong Vũ trụ Điện ảnh Marvel.', './Film/Thor/img.jpg', 
'https://dl3.3rver.org/cdn2/02/film/2011/Thor/Thor%202011.BluRay.720p.mp4', 13, 2011),
(N'Titanic', N'Kate Winslet, Leonardo DiCaprio, Billy Zane, Kathy Bates', N'James Cameron', 8, N'Titanic là một bộ phim điện ảnh thuộc thể loại thảm họa xen lẫn với lãng mạn - sử thi - chính kịch của Mỹ công chiếu năm 1997 do James Cameron làm đạo diễn, viết kịch bản, sản xuất và hỗ trợ tài chính cho phần dựng phim.', './Film/Titanic/img.jpg', 
'https://dl3.3rver.org/cdn2/05/film/1997/Titanic/Titanic.1997.mp4', 18, 1997),
(N'Venom', N'Tom Hardy, Tom Holland, Michelle Williams, Naomie Harris', N'Ruben Fleischer, Andy Serkis', 7, N'Venom: Đối mặt tử thù (tựa gốc tiếng Anh: Venom: Let There Be Carnage) là một bộ phim siêu anh hùng ra mắt năm 2021 của Mỹ, dựa trên nhân vật Venom, được Columbia Pictures cùng với Marvel và Tencent Pictures đồng sản xuất. Được phân phối bởi Sony Pictures Releasing, phim sẽ là phần hậu truyện của Venom (2018)', './Film/Venom/img.jpg', 
'https://dl3.3rver.org/cdn2/05/film/2018/Venom/Venom.2018.mp4', 13, 2018),
(N'X-Men', N'Charles Xavier, Erik Lehnsherr, Jean Grey, Ororo Munroe', N'Simon Kinberg, James Mangold, Matthew Vaughn, Josh Boone, Gavin Hood, Brett Ratner, Bryan Singer', 7, N'X-Men là loạt phim siêu anh hùng của Mỹ dựa trên nhóm siêu anh hùng cùng tên trong các ấn phẩm truyện tranh do Stan Lee và Jack Kirby sáng tác và được Marvel Comics phát hành. Hãng 20th Century Fox giành được quyền chuyển thể nhân vật lên màn ảnh vào năm 1994', './Film/XMen/img.jpg', 
'https://dl3.3rver.org/cdn2/07/film/2009/x-men-origins-wolverine/X-Men.Origins.Wolverine.trailer.mp4', 13, 2000);

INSERT INTO `Film_Genre` (`MaF`, `MaTL`) VALUES
(1, 1),
(1, 4),

(2, 10),

(3, 10),

(4, 10),

(5, 10),

(6, 10),

(7, 1),

(8, 10),

(9, 10),

(10, 4),

(11, 5),

(12, 10),

(13, 10),

(14, 10),

(15, 1),
(15, 4),

(16, 1),
(16, 4),

(17, 10),

(18, 6),

(19, 10),

(20, 10);

INSERT INTO `Comment` (`MaUser`, `MaF`, `Content`, `Times`) VALUES
(1, 1, N'Phim hay qua ...', '7:39 02/03/2020'),
(2, 2, N'Phim hay qua troi', '7:31 12/05/2021'),
(3, 3, N'Phim hay', '9:32 15/02/2022'),
(4, 4, N'Phim hay haha', '3:49 13/07/2021'),
(5, 5, N'Phim hay hehe', '6:35 17/02/2022'),
(4, 6, N'Phim hay ...', '1:23 11/06/2019'),
(1, 7, N'Phim hay xuat sac', '7:39 16/02/2022'),
(4, 7, N'Phim hay qua', '11:32 19/07/2021'),
(1, 8, N'Phim hay qua', '15:01 12/09/2020'),
(3, 9, N'Phim hay qua', '6:12 17/10/2021'),
(2, 10, N'Phim hay qua', '9:19 12/11/2022'),
(5, 11, N'Phim hay qua', '2:34 18/12/2020'),
(2, 11, N'Phim hay qua', '2:52 10/07/2021'),
(4, 13, N'Phim hay qua', '7:43 12/02/2020'),
(3, 14, N'Phim hay qua', '8:04 17/07/2022'),
(3, 15, N'Phim hay qua', '15:06 01/05/2020'),
(5, 16, N'Phim hay qua', '20:39 22/08/2021'),
(1, 17, N'Phim hay qua', '22:43 30/09/2021'),
(4, 18, N'Phim hay qua', '5:12 10/12/2021'),
(2, 20, N'Phim hay qua', '12:30 19/07/2022');

INSERT INTO `Favorite` (`MaUser`, `MaF`) VALUES
(1, 1),
(1, 4),
(1, 6),
(1, 8),

(2, 10),
(2, 15),
(2, 20),
(2, 5),

(3, 7),
(3, 8),
(3, 10),
(3, 16),

(4, 1),
(4, 11),
(4, 13),
(4, 16),

(5, 17),
(5, 9),
(5, 4),
(5, 5);