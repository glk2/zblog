use zblog
create table user (
id int (11) not null auto_increment,
usr_name varchar(100) not null,
usr_password varchar(100) not null,
usr_email varchar(60) not null,
usr_password_salt varchar(100) default null,
usr_registration_date datetime default null,
primary key (id),
unique key uniq_usr_name (usr_name)
) engine = innodb auto_increment = 1 default charset = utf8;