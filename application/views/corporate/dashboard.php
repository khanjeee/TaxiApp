<div>
<table >
<p><strong>Corporate Journey stats (past 7 days)</strong></p>
<tbody>
<tr class="odd">
<th>Total Journeys</th>	
<td><?php echo $total_trips;  ?></td>
</tr>
<tr class="even">
<th>Total Amount</th>	
<td><?php echo  empty($total_amount)? CURRENCY_UNIT."0" : CURRENCY_UNIT.$total_amount;  ?></td>
</tr>
		
</tbody>
</table>
</div>
