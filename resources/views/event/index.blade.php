<x-app-layout>
    <x-slot name="content">
        <a href="{{route('api.events.export')}}" target="_blank">Export</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Fees</th>
                </tr>
            </thead>
            <tbody id="event-list">
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled" id="previous">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
              </li>
              <li class="page-item disabled" id="next">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
        </nav>
    </x-slot>
</x-app-layout>
<script>
    let page = 1;
    let previousLink = document.getElementById('previous');
    let nextLink = document.getElementById('next');
    
    nextLink.addEventListener('click', function () {
        page++;
        setPagination(page);
    });

    previousLink.addEventListener('click', function () {
        page--;
        setPagination(page);
    });
    
    function getEvents(page = 1) {
        axios.get(`/api/events?page=${page}`).then(res => {
            if (!res.data.data.has_error) {
                let table = document.getElementById('event-list');
                let events = res.data.data.events.data;
                let rows = '';
                if (events.length) {
                    events.forEach(event => {
                        rows = `${rows}
                            <tr>
                                <td>${event.name}</td>
                                <td>${event.place}</td>
                                <td>${event.start_date}</td>
                                <td>${event.end_date}</td>
                                <td>${event.fees}</td>
                            </tr>`;
                    });
                } else {
                    rows = `
                        <tr>
                            <td colspan='5' class="text-center">No event found</td>
                        </tr>`;
                }
                if (events.length && res.data.data.events.next_page_url == null) {
                    disableLink(nextLink);
                } else {
                    enableLink(nextLink);
                }
                table.innerHTML = rows;
            }
        }).catch(err => {
            alert('Please after some time');
        });
    }

    function enableLink(link) {
        link.classList.remove('disabled');
    }

    function disableLink(link) {
        link.classList.add('disabled');
    }

    function setPagination(page = 1) {
        getEvents(page);
        if (page > 1) {
            enableLink(previousLink);
        } else {
            disableLink(previousLink);
        }
    }
    getEvents();
</script>