select space_name,
	sum(case when '12'=date_format(start_date,'%m')then price else 0 end)as '12'
from (select service.*,new_essential.space_name from service join new_essential on service.booking_no=new_essential.booking_no) as t
group by space_name;
