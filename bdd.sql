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
    corde DECIMAL,
    tmax_p DECIMAL,
    fmax_p DECIMAL,
    tmax DECIMAL,
    fmax DECIMAL,
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
    x DECIMAL,
    t DECIMAL,
    f DECIMAL,
    yintra DECIMAL,
    yextra DECIMAL,
    id_param INT,
    lgx DECIMAL,
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