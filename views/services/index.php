<?php foreach($categories as $categorie): ?>

<section class="py-16">

    <div class="text-center mb-10">

        <?php if(!empty($categorie['image'])): ?>

            <img 
                src="<?= htmlspecialchars($categorie['image']) ?>"
                alt="<?= htmlspecialchars($categorie['nom']) ?>"
                class="w-full h-64 object-cover rounded-lg"
            >

        <?php endif; ?>


        <h2>
            <?= htmlspecialchars($categorie['nom']) ?>
        </h2>


        <p>
            <?= htmlspecialchars($categorie['description']) ?>
        </p>

    </div>


    <div class="grid md:grid-cols-3 gap-8">


        <?php foreach($categorie['services'] as $service): ?>


            <div>

                <h3>
                    <?= htmlspecialchars($service['nom']) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($service['description']) ?>
                </p>

                <span>
                    <?= htmlspecialchars($service['prix']) ?> HTG
                </span>

            </div>


        <?php endforeach; ?>


    </div>


</section>


<?php endforeach; ?>