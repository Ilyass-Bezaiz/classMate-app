<div>
  <canvas id="absencesChart" height="50"></canvas>
</div>
@script
  <script>
    document.addEventListener('livewire:navigated', function() {
      const ctx = document.getElementById('absencesChart').getContext('2d');
      let chartData = @json($absenceSessionPerTeacher);

      let labels = [];
      let data = [];

      Object.keys(chartData).forEach(moduleName => {
        labels.push(moduleName);
        data.push(chartData[moduleName].sessions);
      });

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Absence par module',
            data: data,
            backgroundColor: 'rgba(63, 81, 181, .2)',
            borderColor: 'rgba(63, 81, 181, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
        }
      });
    });
  </script>
@endscript
