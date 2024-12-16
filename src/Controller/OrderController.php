<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class OrderController extends AbstractController
{

    private $orderRepository;
    private $entityManager;

    public function __construct(
        OrderRepository $orderRepository,
        ManagerRegistry $doctrine
    ) {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/store/order/{product}', name: 'order_store')]
    public function store(Product $product): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $order = new Order();
        $order->setPname($product->getName());
        $order->setPrice($product->getPrice());
        $order->setStatus('processing...');
        $order->setUser($this->getUser());


            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $this->entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Your order was saved'
            );

            return $this->redirectToRoute('user_order_list');
        }

       
    }


