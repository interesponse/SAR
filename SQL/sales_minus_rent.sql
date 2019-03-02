select f.space_name,`01`-rent as '01',`02`-rent as'02',`03`-rent as'03',`04`-rent as'04',
					`05`-rent as '05',`06`-rent as'06',`07`-rent as'07',`08`-rent as'08',`09`-rent as'09',
					`10`-rent as '10',`11`-rent as'11',`12`-rent as'12'
from(select space_name,
	sum(case when '01'=date_format(start_date,'%m')then price else 0 end)as '01',
	sum(case when '02'=date_format(start_date,'%m')then price else 0 end)as '02',
	sum(case when '03'=date_format(start_date,'%m')then price else 0 end)as '03',
	sum(case when '04'=date_format(start_date,'%m')then price else 0 end)as '04',
	sum(case when '05'=date_format(start_date,'%m')then price else 0 end)as '05',
	sum(case when '06'=date_format(start_date,'%m')then price else 0 end)as '06',
	sum(case when '07'=date_format(start_date,'%m')then price else 0 end)as '07',
	sum(case when '08'=date_format(start_date,'%m')then price else 0 end)as '08',
	sum(case when '09'=date_format(start_date,'%m')then price else 0 end)as '09',
	sum(case when '10'=date_format(start_date,'%m')then price else 0 end)as '10',
	sum(case when '11'=date_format(start_date,'%m')then price else 0 end)as '11',
	sum(case when '12'=date_format(start_date,'%m')then price else 0 end)as '12'
from (select service.*,new_essential.space_name from service join new_essential on service.booking_no=new_essential.booking_no
	where start_date between '2018-01-01' and '2019-03-01') as t
group by space_name)as f join spaces on space_name=spaces.name;
