<?php

namespace ToG\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ToG\ForumBundle\Entity\Post;
use ToG\ForumBundle\Entity\Topic;

class LoadPost implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $forumRepository = $this->container->get('doctrine')->getRepository('ToGForumBundle:Forum');
        $forums = $forumRepository->findAll();

        $topicRepository = $this->container->get('doctrine')->getRepository('ToGForumBundle:Topic');
        $topics = $topicRepository->findAll();

        $userRepository =$this->container->get('doctrine')->getRepository('ToGUserBundle:User');
        $users = $userRepository->findAll();

        $postText = array(
            "- Non rassure-toi, mais je suis certaine que tu en redemanderas vite, s'amusa Asuka. Klaad cuisine excellemment bien, et comme il n'oublie jamais un visage, je n'ai jamais vu une bagarre éclater ici.
            - Peu importe la qualité de la cuisine, je pense me régaler de toute manière ! intervint Daal. J'ai l'impression que cela faisait des années depuis mon dernier passage dans une cantina digne de ce nom !

            Son passage en captivité avait dû lui paraitre bien long, mais les événements s'étaient enchaînés si vite après qu'Asuka partageait l'avis du Balosar. C'était peut-être ce sentiment qui la laissait vidée, avec le désir d'en profiter le plus possible tant que ça durait.
            La jeune femme ferma les yeux un instant et se laissa aller, emplissant sa mémoire des bruits environnants. Lorsqu'elle rouvrit les yeux, ce fut pour croiser le regard de Haryù qui la dévisageait avec un air indéchiffrable.
            Ce qui eut pour effet de rendre Asuka légèrement mal à l'aise. Les deux femmes avaient beau avoir discuté un peu ensemble, l'Impériale restait une énigme pour la contrebandière. Si elles n'avaient pas eu Meruem comme lien, elle doutait que Haryù ne l'ait suivie.",
            "Comme escompté, le Chiss ne se révéla guère bavard, et la contrebandière rejoignit Mira sans en savoir guère plus, sinon que l'ex-Impérial avait bel et bien ce qu'il cherchait.
            La Justicière l'attendait de pied ferme dans le hall de la cantina, le Baron à ses côtés, une main tenant son moignon. Asuka acquiesça lorsque Mira l'informa de la réussite de sa négociation. Surement avec de biens gros avantages pour ce Hutt, mais si elles avaient ce qu'elles souhaitaient...",
            "Spectre la regarda longuement dans les yeux, sans dire un mot. Il ne voyait aucun intérêt à l’emmener avec lui, mais il savait qu’elle ne le lâcherait pas. A moins d’assomer ou tuer Suginami pour s’en débarrasser, elle n’en démordrait pas. Blasé, il poussa un long soupir de résignation :

            - Bon, si tu n’as plus rien à faire ici, en route... et pas un mot ! Lui intima-t-il sur un ton ferme en la regardant.

            Sur ce, Spectre tourna encore une fois les talons pour se diriger vers le Hangar 41 où l’attendait son vaisseau.",
            "Ainsi le plan un peu simplet de l'Empereur Émérite était accepté par sa successeur et l'ensemble du Conseil de Guerre. Gilad espérait vraiment que cela fonctionnerait, car il sentait que les Dissidents sont une véritable menace pour le Conglomérat Impérial et surtout pour sa famille. Il avait confiance en Gorgone pour mener à bien cette mission, après tout c'était la fille d'un de ses plus fidèles amis, Loghit Vall. L'Impératrice enchainait avec un sujet, tout aussi important. L'invasion de Taris par la Fédération du Commerce, Gilad avait suivi cela d'assez loin. Il trouvait étrange que les Neimodiens s'approchent aussi près des frontières du Conglomérat, c'était pour lui une enième mascarade orchestrée par Grendo S'orn. Ghent pensait comme lui apparemment, car il fut le premier à réagir. Mitth'root'uprady pensait que les Républiques ne laisseraient pas cet affront impuni, mais le soucis des Républiques , c'est qu'elles sont géographiquement loin de la planète ville.",
            "Tasha haussa les épaules à la réponse d'Asuka : « On ne te laisse pas vraiment le choix de toute façon, tu es maintenant la gardienne de ces cendres. Libre à toi d'en décider le destin ! » Ce disant, elle refourgua de force l'urne dans les mains de la rouquine et fit quelques pas en arrière. « Je suis sûre que nous sommes toutes les deux des femmes assez fortes pour poursuivre notre route, Asuka. Nous ferons notre deuil, et poursuivrons pour tous ceux qui sont encore là, et ceux à venir » ajouta-t-elle dans un clin d'œil, en caressant son ventre. La nuit avait semblé aider madame Raltir à se remettre, et elle était prête pour la suite des aventures.

            Le vaisseau parti, les Jedi et leurs camarades présents déboitèrent en direction de la cabane quand Asuka fit la remarque à Raltir alors qu'il passait tout à fait innocemment à côté.",
            "En arrivant dans les jardins, l'attention de Hana fut attirée par une navette qui venait de décoller, une antique navette J-1. Elle se protégea les yeux avec la tranche de la main et la regarda disparaître dans le ciel, se demandant qui était à son bord et où ils allaient. Cela lui fit penser que Raltir n'était pas la seule personne qu'elle aurait voulu revoir avant de partir... Si elle n'avait pas été aussi fatiguée après la cérémonie de la veille, elle aurait pris le temps de faire ses au revoir. Elle fut tirée de ses pensées par la voix maintenant familière de Reilly, accompagnée de quelques Jedi (deux Humains, dont un garçon qui devait avoir un ou deux ans de moins qu'elle, et un Kiffar – le chevalier sans apprenti). Ce fut la Mirialane qui s'occupa des présentations, et Pravuil ne manqua pas de souffler quelques une des plaisanteries dont il avait le secret. La jeune fille s'inclina tour à tour devant ses trois confrères, avant que le plus jeune ne lui tende la main.",
            "Arrivé à l’hôpital, le médecin alla directement au chevet du Monarque, le trouvant dans un bien piètre état. Des médecins s’affairaient à le maintenir en vie tandis que le Général Monchar ne les quittait pas des yeux. Grendo S’orn respirait, mais vraiment faiblement et les indicateurs de ses signaux de vie sur un écran indiquaient une activité extrêmement et dangereusement basse.

            - Général, j’ai une mauvaise nouvelle. Il semble que le Monarque a été empoisonné.

            - Comment est-ce possible ? Vous en êtes certain ? S’alarma Monchar.",
            "- Ce sont des chefs de gangs venus de diverses planètes. Thyferra, Andara, Balosar, ... Quelques autres moins importantes, comme Pantolomin.

            Thyferra était une planète d'où la République tirait une grande part de ses réserves de bacta. Quant à Andara, elle hébergeait l'une des plus prestigieuses écoles de la Galaxie, d'où sortait la future élite de la RFN.

            - Ce ne sont pas des bandes très puissantes, ni bien organisées, mais elles sont nombreuses. Enfin je crois, les incertitudes sont assez grandes autour de ces chiffres. Toutefois si elles venaient à recevoir les armes dont vous me parliez, je crois qu'elles seraient assez problématiques à gérer... Une idée de comment de telles bandes peuvent s'offrir des armes de ce calibre ? demanda-t-il à tout hasard. Si vous pouvez parler bien sûr. Vous devriez songer à cette petite amélioration que j'avais évoquée...",
            "Nous sommes en pleine période de Guerre Civile Galactique. L'Empire Galactique règne en maître sur une galaxie divisée. Despote et militariste, l'Empire est une dictature dont la réputation s'est bâtie sur la peur. Une poche de résistance s'est cependant développée au fils des années, jusqu'à la récente création de l'Alliance Rebelle. A la tête de cet Empire, l'Empereur Palpatine et son fidèle apprenti Darth Vader - tous deux Sith. Les garants de la paix dans la galaxie, les Jedi, ont disparu depuis bien longtemps, ou ont fait le nécessaire pour devenir invisibles. L'Ordre Jedi a quant à lui été dissous.

            Désormais les rumeurs parlent d'une nouvelle arme, capable de détruire une planète. Une nouvelle arme qui, dans les mains de l'Empire, signifierait la fin de la liberté et de l'Alliance Rebelle. Une arme surnommée l'Etoile de la Mort.

            [ Nous sommes 1 an avant la Bataille de Yavin, c'est à dire la destruction théorique de la première Etoile de la Mort ]",
        );

        for ($i = 0 ; $i < 500 ; $i ++) {
            $newPost = new Post();

            $rand = rand(0, count($postText) - 1);
            $newPost->setText($postText[$rand]);

            $topic = $topics[rand(0, count($topics) - 1)];
            $newPost->setTopic($topic);

            $newDate = new \DateTime('now');
            $newPost->setPostDate($newDate);

            $user = $users[rand(0, count($users) - 1)];
            $newPost->setUser($user);

            $manager->persist($newPost);

            // Si le Topic n'a pas encore de LastPostId, c'est qu'il n'y a pas encore de Post.
            // Le Post courant va donc être paramétré comme étant le Premier
            if (!empty($topic->getLastPostId())) {
                $topic
                    ->setFirstPosterId($user->getId())
                    ->setFirstPosterName($user->getUsername())
                ;
            }

            $topic
                ->setLastPosterId($user->getId())
                ->setLastPosterName($user->getUsername())
                ->setLastPostId($newPost->getId())
            ;

            $manager->persist($topic);

            $forum = $forumRepository->find($topic->getForum());
            $posts_count = $forum->getPostsCount() + 1;
            $forum->setPostsCount($posts_count);
            $manager->persist($forum);

            $manager->flush();
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4; // Load after topics
    }
}
