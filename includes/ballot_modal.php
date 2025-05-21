<!-- filepath: /c:/xampp/htdocs/votesystem/includes/ballot_modal.php -->
<!-- Preview -->
<div class="modal fade" id="preview_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pratinjau Pilihan</h4>
      </div>
      <div class="modal-body">
        <div id="preview_body"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Platform -->
<div class="modal fade" id="platform">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="candidate"></b></h4>
      </div>
      <div class="modal-body">
        <div id="plat_view"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- View Ballot -->
<div class="modal fade" id="view">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Pilihan Anda</b></h4>
      </div>
      <div class="modal-body">
        <?php
        $id = $voter['id'];
        $sql = "SELECT *, candidates.fullname AS canfullname FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id WHERE voters_id = '$id' ORDER BY positions.priority ASC";
        $query = $conn->query($sql);
        while ($row = $query->fetch_assoc()) {
          echo "
            <div class='votelist'>
              <p class='text-center'><b>" . $row['description'] . "</b></p>
              <p class='text-center'>" . $row['canfullname'] . "</p>
            </div>
          ";
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>