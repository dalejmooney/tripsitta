let filterClass = {
    triggerFilters() {
        $('.filters-column').toggleClass('mobile-active');
        $('body').toggleClass('disable-scroll');
    },

    filter() {
        // filter selections
        let filter_experience_selected = $('input[name="experience[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let filter_experience_age_groups_selected = $('input[name="filter_experience_age[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let filter_languages_selected = $('input[name="filter-language[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let filter_first_aid_selected = $('input[name="filter-first_aid"]').prop('checked');
        filter_first_aid_selected = filter_first_aid_selected ? 1 : 0;

        let filter_review_selected = $('input[name="filter-review[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let filter_qualification_selected = $('input[name="filter-qualifications"]').prop('checked');
        filter_qualification_selected = filter_qualification_selected ? 1 : 0;

        $(".babysitter").each(function (index, element) {
            let babysitter_experience = parseInt($(element).data('experience'));
            let babysitter_experience_age_groups = $(element).data('experience_age_groups');
            let babysitter_languages = $(element).data('languages');
            let babysitter_first_aid = $(element).data('first_aid');
            let babysitter_review_count = $(element).data('review_count');
            let babysitter_review_score = $(element).data('review_score');
            let babysitter_has_qualifications = $(element).data('qualifications');

            let is_visible_experience = filterClass.filterExperience(babysitter_experience, filter_experience_selected);
            let is_visible_experience_age_groups = filterClass.filterExperienceAgeGroups(babysitter_experience_age_groups, filter_experience_age_groups_selected);
            let is_visible_languages = filterClass.filterLanguages(babysitter_languages, filter_languages_selected);
            let is_visible_first_aid = filterClass.filterFirstAid(babysitter_first_aid, filter_first_aid_selected);
            let is_visible_reviews = filterClass.filterReviews(babysitter_review_count, babysitter_review_score, filter_review_selected);
            let is_visible_qualifications = filterClass.filterQualifications(babysitter_has_qualifications, filter_qualification_selected);

            if (is_visible_experience && is_visible_experience_age_groups && is_visible_languages && is_visible_first_aid && is_visible_reviews && is_visible_qualifications) {
                $(element).show();
            } else {
                $(element).hide();
            }
        });

        if ($(".babysitter:visible").length === 0) {
            $('.babysitter-notifications').html(`<div class="hero is-info is-medium has-margin-bottom-xl">
                     <div class="hero-body has-text-centered">
                         <h3 class="title is-4">We didn't find a babysitter matching your requirements</h3>
                         <p class="subtitle is-6">Please try adjusting your filters or contact us and we'll try to help you !</p>
                         <p><a href="mailto:info@tripsitta.com" class="has-text-white has-text-weight-bold">info@tripsitta.com</a> or <a href="tel:+393920397288" class="has-text-white has-text-weight-bold">+39 392 039 7288</a></p>
                     </div>
                 </div>`);
        } else {
            $('.babysitter-notifications').empty();
        }

        if ($('.filters_show').is(':visible')) {
            filterClass.triggerFilters();
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".babysitters-container").offset().top
            }, 2000);
        }
    },

    filterExperience($experience_value, $selected_filters) {
        if ($selected_filters.length === 0) return true;

        if ($.inArray('0', $selected_filters) !== -1 && $experience_value === 0) return true;
        if ($.inArray('1', $selected_filters) !== -1 && $experience_value === 1) return true;
        if ($.inArray('2', $selected_filters) !== -1 && $experience_value >= 2 && $experience_value < 5) return true;
        if ($.inArray('5', $selected_filters) !== -1 && $experience_value >= 5) return true;

        return false;
    },

    filterExperienceAgeGroups($experience_value, $selected_filters) {
        if ($selected_filters.length === 0) return true;

        if ($.inArray('0', $selected_filters) !== -1 && $.inArray('0', $experience_value) !== -1) return true;
        if ($.inArray('1', $selected_filters) !== -1 && $.inArray('1', $experience_value) !== -1) return true;
        if ($.inArray('4', $selected_filters) !== -1 && $.inArray('4', $experience_value) !== -1) return true;
        if ($.inArray('8', $selected_filters) !== -1 && $.inArray('8', $experience_value) !== -1) return true;
        if ($.inArray('12', $selected_filters) !== -1 && $.inArray('12', $experience_value) !== -1) return true;

        return false;
    },

    filterLanguages($languages_value, $selected_filters) {
        if ($selected_filters.length === 0) return true;

        let found = false;
        $.each($languages_value, function (i, filter) {
            if ($.inArray(filter, $selected_filters) !== -1) {
                found = true;
                return false;
            }
        });

        return found;
    },

    filterFirstAid($first_aid_value, $selected_filter) {
        if ($selected_filter === 0) return true;

        if ($first_aid_value === $selected_filter) return true;

        return false;
    },

    filterQualifications(qualification_value, selected_filter) {
        if (selected_filter === 0) return true;

        if (qualification_value === selected_filter) return true;

        return false;
    },

    filterReviews(babysitter_review_count, babysitter_review_score, selected_filters) {
        if (selected_filters.length === 0) return true;

        if ($.inArray('0', selected_filters) !== -1 && babysitter_review_count === 0) return true;

        if (babysitter_review_count > 0) {
            if ($.inArray('1', selected_filters) !== -1 && babysitter_review_score > 1 && babysitter_review_score < 2) return true;
            if ($.inArray('2', selected_filters) !== -1 && babysitter_review_score > 2 && babysitter_review_score < 3) return true;
            if ($.inArray('3', selected_filters) !== -1 && babysitter_review_score > 3 && babysitter_review_score < 4) return true;
            if ($.inArray('4', selected_filters) !== -1 && babysitter_review_score > 4 && babysitter_review_score < 5) return true;
            if ($.inArray('5', selected_filters) !== -1 && babysitter_review_score === 5) return true;
        }

        return false
    },
};

module.exports = filterClass;
