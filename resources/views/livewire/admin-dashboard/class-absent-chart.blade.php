<div>
    <div class="chart-container">
        <canvas id="classAbsenceChart"></canvas>
    </div>
</div>

@push('scripts')
    <script>
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
@endpush
