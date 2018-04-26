create database user8;
#-------------------------------------------------------------------------------
#--- Change database -----------------------------------------------------------
#-------------------------------------------------------------------------------
use user8;
#-------------------------------------------------------------------------------
#--- Database cleanup ----------------------------------------------------------
#-------------------------------------------------------------------------------
drop table if exists parametre;
drop table if exists cambrure;
#-------------------------------------------------------------------------------
#--- Database creation ---------------------------------------------------------
#-------------------------------------------------------------------------------
create table parametre
(
    id INT not null
    auto_increment,
    libelle VARCHAR
    (40),
    corde DOUBLE,
    tmax_p DOUBLE,
    fmax_p DOUBLE,
    tmax DOUBLE,
    fmax DOUBLE,
    nb_points INT,
    date DATE,
    fic_img VARCHAR
    (256),
    fic_csv VARCHAR
    (256),
    primary key
    (id)
)
engine = innodb;
    create table cambrure
    (
        id int not null
        auto_increment,
    x DOUBLE,
    t DOUBLE,
    f DOUBLE,
    yintra DOUBLE,
    yextra DOUBLE,
    id_param INT,
    lgx DOUBLE,
    primary key
        (id),
    foreign key
        (id_param) references parametre
        (id)
)
engine = innodb;

#-------------------------------------------------------------------------------
#--- Populate databases --------------------------------------------------------
#-------------------------------------------------------------------------------
        set autocommit
        = 0;
        set names utf8;