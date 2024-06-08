<div>
  <canvas id="absencesChart" height="50"></canvas>
</div>
@script
  <script>
    let ctx = document.getElementById('absencesChart').getContext('2d');
    let chartData = @json($classesData);
    // Extraire les labels et les données du chartData
    let labels = [];
    let data = [];

    for (let classId in chartData) {
      labels.push(chartData[classId].class_name);
      data.push(chartData[classId].sessions);
    }

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Student Absences',
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
    console.log(labels, data);
  </script>
@endscript
