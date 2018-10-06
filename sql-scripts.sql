drop table pl_exception;
create table pl_exception (
	id int not null auto_increment,
	name varchar(200) not  null,
	primary key (id)
);
insert into pl_exception (name) value ('Слово ж.р. с окончанием ים во мн.ч.');
insert into pl_exception (name) value ('Слово м.р. с окончанием ות во мн.ч.');
insert into pl_exception (name) value ('Слово ж.р. без окончания в ед.ч.');

create table word (
	id int not null auto_increment,
	word varchar(200) not  null,
	translation varchar(200) not  null,
	gender char(1) not  null,
	plural varchar(200),
	plural_translation varchar(200),
	part_of_speech varchar(50),
	comment varchar(200) CHARACTER SET utf8 ,
	exception_id int,
	primary key (id),
	foreign key exception_id references pl_exception(id)
);


insert into word (word, translation, gender, plural, plural_translation) values
('ספר', 'книга', 'm', 'ספרים', 'книги');
insert into word (word, translation, gender, plural, plural_translation) values
('ספרייה', 'библиотека', 'f', null, null);
insert into word (word, translation, gender, plural, plural_translation) values
('מחשב ', 'компьютер', 'm', 'מחשבים', 'компьютеры');
insert into word (word, translation, gender, plural, plural_translation) values
('כיתה ', 'класс', 'f', 'כיתות', 'классы');
insert into word (word, translation, gender, plural, plural_translation) values
('דירה ', 'квартира', 'f', 'דירות', 'квратиры');


drop table page;
CREATE TABLE page (
	id int(11) NOT NULL auto_increment,
	title varchar(200) CHARACTER SET utf8 NOT NULL,
	subtitle varchar(200) CHARACTER SET utf8  NULL,
	description varchar(200) CHARACTER SET utf8  NULL,
	url varchar(200) CHARACTER SET utf8  NULL,
	primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into page (title, description, url) values ('Список слов', 'Список слов, которые нужно знать', '/words.php');
insert into page (title, description, url) values ('Список глаголов', 'Список пройденных глаголов по группам', '/verbs.php');

insert into page (title, description, url) values ('Список исключений', 'Список существительных с особым окончанием во мн.ч.', '/nouns_exceptions.php');

drop table verb_form;
create table verb_form (
	id int not null auto_increment,
	form varchar(200) not  null,
	primary key (id)
);
insert into verb_form (form) values ('סוֹסֵס - סוֹסֶסֶת - סוֹססים/וֹת');

drop table verb;
create table verb (
	id int not null auto_increment,
	ms varchar(200) not  null,
	fs varchar(200) not  null,
	mp varchar(200) not  null,
	fp varchar(200) not  null,
	translation varchar(200) CHARACTER SET utf8  not  null,
	form_id int,
	primary key (id),
	foreign key (form_id) references verb_form(id)
);
insert into verb (ms, fs, mp, fp, translation, form_id) values ('לוֹמד' ,'לוֹמדת', 'לוֹמדים', 'לוֹמדוֹת', 'учит', 1);


create table role (
	id int not null auto_increment,
	name varchar(200) not  null,
	primary key (id)
);
insert into role (name) values ('admin');
insert into role (name) values ('user');

create table webuser (
	id int not null auto_increment,
	username varchar(50) not  null,
	password varchar(200) not  null,
	role_id int not  null,
	primary key (id),
	foreign key (role_id) references role(id)
);

create table webuser_list (
	id int not null auto_increment,
	webuser_id int not null,
	name varchar(50) not null,
	primary key (id),
	foreign key (webuser_id) references webuser(id)
);
create table word_list (
	id int not null auto_increment,
	webuser_list_id int not null,
	word_id int not null,
	added timestamp default now(),
	primary key (id),
	foreign key (word_id) references word(id),
	foreign key (webuser_list_id) references webuser_list(id)
);

drop table training;
create table training (
	id int not null auto_increment,
	webuser_id int not null,
	word_id int not null,
	code varchar(5) not null,
	tries int default 0,
	answered boolean default false,
	primary key (id),
	foreign key (word_id) references word(id),
	foreign key (webuser_id) references webuser(id)
);

/*
#051C3B
#1E3DSA
#57859C
#80A48E
#EXEFEE
*/
insert into users (username, id) values ('user', 2);
insert into webuser_list (name, webuser_id) values ('generic', 2);