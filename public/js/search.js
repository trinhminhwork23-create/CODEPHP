document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('#navbar-search-input');
    
    searchInputs.forEach(input => {
        const container = input.closest('.nav-search-container');
        if (!container) return;
        
        const wrapper = container.querySelector('#search-suggestion-wrapper');
        if (!wrapper) return;
        
        let timeout = null;
        let selectedIndex = -1;
        
        function getItems() {
            return wrapper.querySelectorAll('.search-suggestion-item');
        }
        
        function highlightItem(index) {
            const items = getItems();
            items.forEach((item, idx) => {
                if (idx === index) {
                    item.classList.add('active');
                    item.style.background = 'rgba(223, 169, 116, 0.12)';
                    item.style.transform = 'translateX(4px)';
                } else {
                    item.classList.remove('active');
                    item.style.background = '';
                    item.style.transform = '';
                }
            });
        }
        
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();
            selectedIndex = -1;
            
            if (query.length === 0) {
                wrapper.style.display = 'none';
                wrapper.innerHTML = '';
                return;
            }
            
            // Show loading state with a spinner
            wrapper.innerHTML = '<div class="search-suggestion-loading"><i class="fa fa-spinner fa-spin"></i> Đang tìm phòng...</div>';
            wrapper.style.display = 'block';
            
            timeout = setTimeout(() => {
                const baseUrl = window.roomsSuggestionsUrl || '/rooms/suggestions';
                const url = `${baseUrl}?query=${encodeURIComponent(query)}`;
                console.log('[Search] Fetching:', url);
                
                fetch(url)
                    .then(res => {
                        if (!res.ok) throw new Error('Response error');
                        return res.json();
                    })
                    .then(data => {
                        console.log('[Search] Received suggestions:', data);
                        if (!data || data.length === 0) {
                            wrapper.innerHTML = '<div class="search-suggestion-empty">Không tìm thấy phòng</div>';
                            return;
                        }
                        
                        let html = '';
                        data.forEach(room => {
                            html += `
                                <a href="${room.url}" class="search-suggestion-item">
                                    <img src="${room.image}" alt="${room.name}">
                                    <div class="search-suggestion-info">
                                        <div class="search-suggestion-title">${room.name}</div>
                                        <div class="search-suggestion-meta">
                                            <span class="search-suggestion-category">${room.category}</span>
                                            <span class="search-suggestion-price">${room.price}/đêm</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                        wrapper.innerHTML = html;
                        selectedIndex = -1;
                    })
                    .catch(err => {
                        console.error('[Search] Fetch error:', err);
                        wrapper.innerHTML = '<div class="search-suggestion-empty">Có lỗi xảy ra khi tìm kiếm</div>';
                    });
            }, 300);
        });
        
        input.addEventListener('keydown', function(e) {
            const items = getItems();
            if (items.length === 0) return;
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = (selectedIndex + 1) % items.length;
                highlightItem(selectedIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                highlightItem(selectedIndex);
            } else if (e.key === 'Enter') {
                if (selectedIndex >= 0 && selectedIndex < items.length) {
                    e.preventDefault();
                    items[selectedIndex].click();
                }
            } else if (e.key === 'Escape') {
                wrapper.style.display = 'none';
                this.blur();
            }
        });
        
        // Hide suggestion wrapper when input loses focus
        input.addEventListener('blur', function() {
            setTimeout(() => {
                wrapper.style.display = 'none';
            }, 250);
        });
        
        // Show suggestions again when input is focused if there is query
        input.addEventListener('focus', function() {
            if (this.value.trim().length > 0) {
                wrapper.style.display = 'block';
            }
        });
    });
});
