<div>
  <div class="chart-container">
    <canvas id="absenceChart"></canvas>
  </div>
</div>
@script
  <script>
    const ctx = document.getElementById('absenceChart').getContext('2d');
    let absenceData = @json($absenceData);

    var labels = absenceData.map(item => 'Month ' + item.month);
    var data = absenceData.map(item => item.absence_count);

    var chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Absences',
          data: data,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          fill: false
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
@endscript
