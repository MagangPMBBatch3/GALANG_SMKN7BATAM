<div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
    <div id="paginationInfo" class="text-xs sm:text-sm text-gray-700">
        Menampilkan 0 dari 0 data
    </div>
    <div class="flex items-center gap-4">
        <select id="perPage" class="border p-2 rounded text-sm" onchange="loadDataPaginate(1)">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <div id="paginationLinks" class="flex flex-wrap gap-1 sm:gap-2">
        </div>
    </div>
</div>
