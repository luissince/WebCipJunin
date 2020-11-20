function Peritaje() {
    this.componentesPeritaje = function() {
        $("#btnPeritaje").click(function() {
            $('#mdPeritaje').modal('show');
        });

        $("#btnPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('show');
            }
            event.preventDefault();
        });
    }
}