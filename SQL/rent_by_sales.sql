select f.space_name,rent/`01`as '01',rent/`02` as'02',rent/`03`as'03',rent/`04`as'04',
		rent/`05`as'05',rent/`06`as'06',rent/`07`as'07',rent/`08`as'08',rent/`09`as'09',
		rent/`10`as'10',rent/`11`as'11',rent/`12`as'12'
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
from (select service.*,new_essential.space_name from service join new_essential on service.booking_no=new_essential.booking_no) as t
group by space_name)as f join spaces on space_name=spaces.name;
