
##  Table Revision v.20220820
```
alter table admisecsg_tr_details
    modify id bigint auto_increment;

alter table admisecsg_tr_details
    modify created_at datetime not null;

alter table admisecsg_tr_details
    modify created_by bigint not null;

alter table admisecsg_tr_details
    modify updated_at datetime null;

alter table admisecsg_tr_details
    modify updated_by bigint null;

alter table admisecsgp_tr_headers
    change `is_matched _jpat` `is_matched_jpat` 
    tinyint(1) not null;

alter table admisecsg_tr_details
    modify id bigint auto_increment;

alter table admisecsgp_tr_headers
	add uploaded_at datetime null
```
