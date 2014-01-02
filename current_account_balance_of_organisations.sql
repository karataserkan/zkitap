select transaction_type, transaction_organisation_id, transaction_currency_code, SUM(amount)  as amount  , SUM(amount_equvalent) as  amount_equvalent 
from 
( select transaction_type, transaction_organisation_id, transaction_currency_code, SUM(transaction_amount) as amount , SUM(transaction_amount_equvalent) as amount_equvalent  from transactions where transaction_result = 0 and transaction_method = 'deposit'  group by transaction_type, transaction_organisation_id  
Union
 select transaction_type, transaction_organisation_id, transaction_currency_code,  -1 * SUM(transaction_amount) as amount , -1 * SUM(transaction_amount_equvalent) as amount_equvalent  from transactions where transaction_result = 0 and transaction_method = 'withdrawal'  group by transaction_type, transaction_organisation_id, transaction_currency_code ) 
as tables group by transaction_type, transaction_organisation_id, transaction_currency_code 

