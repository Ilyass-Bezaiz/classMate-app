<div class="chart-container">
  <canvas height="235" id="classAbsenceChart"></canvas>
</div>

@script
  <script>
    document.addEventListener('livewire:navigated', function() {
      const ctx = document.getElementById('classAbsenceChart').getContext('2d');
      let classAbsenceData = @json($classAbsenceData);

      let labels = classAbsenceData.map(item => 'Month ' + item.month);
      let data = classAbsenceData.map(item => item.absence_count);

      let chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Absences',
            data: data,
            borderColor: 'rgb(63, 81, 181)',
            borderWidth: 2,
            fill: false
          }]
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            x: {

              ticks: {
                color: 'rgb(171, 188, 213)' // X-axis text color
              },
              title: {
                display: true,
                text: 'Months',
                color: 'rgb(171, 188, 213)' // X-axis title color
              }
            },
            y: {

              ticks: {
                color: 'rgb(171, 188, 213)' // Y-axis text color
              },
            }
          },
          plugins: {
            legend: {
              labels: {
                color: 'rgb(171, 188, 213)' // Legend text color
              }
            },
            tooltip: {
              bodyColor: 'rgb(171, 188, 213)', // Tooltip text color
              titleColor: 'rgb(171, 188, 213)' // Tooltip title text color
            }
          }
        }
      });
    });
  </script>
@endscript
