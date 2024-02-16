<span class="bg-gray-100 p-2 mb-3 inline-block">
    <input type="text" id="new-item" placeholder="New value" class="bg-gray-200 p-1">
    <button type="button" onclick="addItem()" class="bg-blue-500 text-white p-1">Add</button>
</span>

    <ul id="options">
        @foreach($setting['value'] as $value)
        <li>
            <input type="text" name="value[]" value="{{$value}}" class="bg-gray-100 my-1 px-1">
            <button type="button" class="text-red-500" onclick="removeItem(this)">[X]</button>
        </li>
        @endforeach
    </ul>

    <script>
        function addItem() {
            const newItem = document.getElementById("new-item").value;
            const options = document.getElementById("options");
            const item = document.createElement("li");
            item.innerHTML = `
                <input type="text" name="value[]" value="${newItem}" class="bg-gray-100 my-1 px-1 bg-yellow-200">
                <button type="button" class="text-red-500" onclick="removeItem(this)">[X]</button>
            `;
            options.appendChild(item);
            document.getElementById("new-item").value = "";
        }

        function removeItem(item) {
            item.parentNode.parentNode.removeChild(item.parentNode);
        }
    </script>
