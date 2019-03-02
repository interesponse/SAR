select new_essential.space_name,
	sum(case when new_essential.site_name='Spacee' then service.price else 0 end) as 'spacee',
	sum(case when new_essential.site_name='Resnavi' then service.price else 0 end) as 'resnavi',
	sum(case when new_essential.site_name='Spacemarket' then service.price else 0 end) as 'spacemarket' 
from new_essential join service on new_essential.booking_no=service.booking_no
where service.start_date between '$start_date' and '$end_date' group by new_essential.space_name;
	
