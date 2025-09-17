<div class="flex justify-between items-center mt-4">
    <div id="pageInfo" class="text-sm text-gray-600"></div>

    <div class="flex items-center gap-4">
        <select id="perPage" class="border p-2 rounded" onchange="loadDataPaginate(1)">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>

        <div class="flex gap-2">
            <button id="prevBtn" onclick="prevPage()" class="bg-gray-300 px-3 py-1 rounded disabled:opacity-50">
                Back
            </button>
            <button id="nextBtn" onclick="nextPage()" class="bg-gray-300 px-3 py-1 rounded disabled:opacity-50">
                Next
            </button>
        </div>
    </div>
</div>
