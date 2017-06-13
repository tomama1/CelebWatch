-- Insert into 'Users' Table.
insert into Users (UserName, Password, Email) values ('Phyllis Carroll', sha1('fBvQIZ'), 'pcarroll0@pbs.org');
insert into Users (UserName, Password, Email) values ('Jeffrey Barnes', sha1('OZxj5NGPwSBo'), 'jbarnes1@pagesperso-orange.fr');
insert into Users (UserName, Password, Email) values ('Joyce Brown', sha1('rZDkuptEJ'), 'jbrown2@example.com');
insert into Users (UserName, Password, Email) values ('Phyllis Holmes', sha1('1Es9xby'), 'pholmes3@qq.com');
insert into Users (UserName, Password, Email) values ('Rebecca Brown', sha1('L1UUwR'), 'rbrown4@goodreads.com');

-- Insert into 'Celebrities' Table.
insert into Celebrities (CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) values ('Walter Hernandez', 'Music', '08/19/2015', 'msn.com', 'Walter_Hernandez', 'wikimedia.org', '123456789', 'hostgator.com');
insert into Celebrities (CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) values ('Rose Edwards', 'Film/TV', '11/13/2015', 'paginegialle.it', 'Rose_Edwards', 'google.pl', '945617891', 'stumbleupon.com');
insert into Celebrities (CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) values ('Christina Riley', 'Comedy', '01/29/2016', 'meetup.com','Christina_Riley', 'scribd.com', '651795418', 'deviantart.com');
insert into Celebrities (CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) values ('Donald Reed', 'Sports', '11/23/2015', 't.co', 'Donald_Reed', 'scribd.com', '589148792', 'guardian.co.uk');
insert into Celebrities (CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) values ('Matthew Wheeler', 'Modeling', '02/07/2016', 'archive.org', 'Matthew_Wheeler', 'japanpost.jp', '987451268', 'yale.edu');

-- Insert into 'MyCelebs' Table.
insert into MyCelebs (CelebID, UserID) values (692, 457);
insert into MyCelebs (CelebID, UserID) values (42, 427);
insert into MyCelebs (CelebID, UserID) values (603, 812);
insert into MyCelebs (CelebID, UserID) values (96, 526);
insert into MyCelebs (CelebID, UserID) values (214, 450);

-- Insert into 'Requests' Table.
insert into Requests (Celeb, UserID, RequestTime, Descrp) values ('Brian Mendoza', 311, '2015-08-29 11:43:41', 'Praesent lectus. Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.');
insert into Requests (Celeb, UserID, RequestTime, Descrp) values ('Amanda Perkins', 54, '2015-10-30 16:45:52', 'Integer tincidunt ante vel ipsum.');
insert into Requests (Celeb, UserID, RequestTime, Descrp) values ('Juan Price', 328, '2015-08-10 20:24:14', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.');
insert into Requests (Celeb, UserID, RequestTime, Descrp) values ('Dennis Alvarez', 118, '2015-08-14 11:35:17', 'Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.');
insert into Requests (Celeb, UserID, RequestTime, Descrp) values ('Jimmy Robinson', 271, '2015-05-05 09:22:10', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor.');
