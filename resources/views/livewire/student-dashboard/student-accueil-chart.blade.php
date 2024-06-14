<div>
  <canvas id="absencesChart" height="50"></canvas>
</div>
@script
  <script>
    document.addEventListener('livewire:navigated', function() {
      let ctx = document.getElementById('absencesChart').getContext('2d');
      let chartData = @json($absenceSessionPerTeacher);
      // Extraire les labels et les données du chartData
      let labels = [];
      let data = [];

      for (let teacherName in chartData) {
        labels.push(chartData[teacherName].teacher_name);
        data.push(chartData[teacherName].sessions);
      }

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Votre Absences Par Professeur',
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
