select space_name,AVG(datediff(start_date,application))
from(select new_essential.*,client.application 
from new_essential join client on new_essential.client=client.id)as t join service on t.booking_no=service.booking_no
where start_date between '2018-01-01' and '2019-01-01'
group by space_name;
