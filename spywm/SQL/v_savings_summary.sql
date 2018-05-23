/* Author: Femi Adeleke */
/* Date: 05/23/2018 */
/* Object: VIEW ; Name: v_savings_summary */
/* Description: Savings Account Summary */

create view v_savings_summary
as
select 
atxn.account_trxn_id,
atxn.customer_id,
atxn.created_date,
atxn.amount,
stxn.deposit_amount,
atxn.account_action_id,
stxn.withdrawal_amount,
sa.prd_offering_id,
stxn.balance
from account_trxn atxn join savings_trxn_detail stxn using (account_trxn_id)
join savings_account sa using (account_id)
order by atxn.created_date;

