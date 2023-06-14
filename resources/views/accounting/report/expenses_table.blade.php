<div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered table-sm" style="font-size: 12px;">
      <tbody>
          <tr>
            <td>1</td>
            <th>Today's Expenses</th>
            <td><strong>&#8358;{{ number_format($expensesToday,0) }}</strong></td>
          </tr>
          <tr>
            <td>2</td>
            <th>This Week's Expenses</th>
            <td><strong>&#8358;{{ number_format($expensesThisWeek,0) }}</strong></td>
          </tr>
          <tr>
            <td>3</td>
            <th>This Month's Expenses</th>
            <td><strong>&#8358;{{ number_format($expensesThisMonth,0) }}</strong></td>
          </tr>
          <tr>
            <td>4</td>
            <th>Total Expenses (This Term)</th>
            <td><strong>&#8358;{{ number_format($total,0) }}</strong></td>
          </tr>
          
      </tbody>
    </table>
  </div>