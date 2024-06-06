
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        let searchTerm = $(this).val().trim();

        if (searchTerm.length >= 3) {
            $('#searchResultsVideo, #searchResultsStatement, #searchResultsUser').empty();

            let searchConfigs = [
                {url: '/video/autocomplete', resultsDiv: '#searchResultsVideo', template: 'video'},
                {url: '/statement/autocomplete', resultsDiv: '#searchResultsStatement', template: 'statement'},
                {url: '/user/autocomplete', resultsDiv: '#searchResultsUser', template: 'user'}
            ];
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            searchConfigs.forEach(function(config) {
                $.ajax({
                    type: 'GET',
                    url: config.url,
                    data: { search: searchTerm },
                    success: function(response) {
                        let resultsDiv = $(config.resultsDiv);
                        resultsDiv.empty();

                        if (config.template === 'user') {
                            $.each(response.users, function(index, user) {
                                let template = `
                                    <a href="/profileuser/${user.id}">
                                        <div class="statement_block">
                                            <div class="statement_block_top">
                                                <div class="statement_block_top_info_left">
                                                    <div class="statement_block_top_avatar">
                                                    <img class="avatar_mini" src="${user.avatar ? response.base_url + '/' + user.avatar : '/uploads/ProfilePhoto.png'}" alt="Photo">
                                                    </div>
                                                    <div class="statement_block_top_info">
                                                        <div class="statement_block_top_info_name">${user.name}</div>
                                                        <div class="statement_block_top_info_createdat">${user.condition}</div>
                                                    </div>
                                                </div>
                                                <div class="statement_block_top_info_right">
                                                    <div class="statement_block_top_info_right_info">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>`;
                                resultsDiv.append(template);
                            });
                        } else {
                            $.each(response[config.template + 's'], function(index, item) {
                                let template = `
                                    <a href="/${config.template}user/${item.id}">
                                        <div class="statement_block">
                                            <div class="statement_block_top">
                                                <div class="statement_block_top_info_left">
                                                    <div class="statement_block_top_avatar">
                                                    <img class="avatar_mini" src="${item.user.avatar ? response.base_url + '/' + item.user.avatar : '/uploads/ProfilePhoto.png'}" alt="Photo">

                                                    </div>
                                                    <div class="statement_block_top_info">
                                                        <div class="statement_block_top_info_name">${item.user.name}</div>
                                                        <div class="statement_block_top_info_createdat">${item.created_at}</div>
                                                    </div>
                                                </div>
                                                <div class="statement_block_top_info_right">
                                                    <div class="statement_block_top_info_right_info">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="statement_block_middle">
                                                <img src="${response.base_url}/${item.thumbnail_path || item.photo_path}" alt="Photo">
                                            </div>
                                            <div class="statement_block_down">
                                                <div class="statement_block_down_title">${item.title}</div>
                                                <div class="statement_block_down_description">${item.description}</div>
                                            </div>
                                        </div>
                                    </a>`;
                                resultsDiv.append(template);
                            });
                        }
                    }
                });
            });
        } else {
            $('#searchResultsVideo, #searchResultsStatement, #searchResultsUser').empty();
        }
    });
});

